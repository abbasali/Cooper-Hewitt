<?php
// $Id: session.singlesignon.inc,v 1.1 2009/09/30 18:55:11 meba Exp $

/**
 * @file
 * Single sign-on session handling functions.
 *
 *  - Stores additional SSO information per session
 *  - Enforces domain-restrictions for sessions
 *  - Links up controller/client sessions and keeps them in sync
 *  - Contains helper functions for claiming / deleting linked sessions
 *
 * Based on: session.inc,v 1.44.2.6 2008/12/11 00:29:34 goba
 */

function sess_open($save_path, $session_name) {
  return TRUE;
}

function sess_close() {
  return TRUE;
}

function sess_read($key) {
  global $user;

  // Write and Close handlers are called after destructing objects since PHP 5.0.5
  // Thus destructors can use sessions but session handler can't use objects.
  // So we are moving session closure before destructing objects.
  register_shutdown_function('session_write_close');

  // Handle the case of first time visitors and clients that don't store cookies (eg. web crawlers).
  if (!isset($_COOKIE[session_name()])) {
    $user = drupal_anonymous_user();
    return '';
  }

  // Otherwise, if the session is still active, we have a record of the client's session in the database.
  $user = db_fetch_object(db_query("SELECT u.*, s.* FROM {users} u INNER JOIN {sessions} s ON u.uid = s.uid WHERE s.sid = '%s' AND s.domain = '%s'", $key, singlesignon_get_domain()));

  // We found the client's session record and they are an authenticated user
  if ($user && $user->uid > 0) {
    // This is done to unserialize the data member of $user
    $user = drupal_unpack($user);

    // Add roles element to $user
    $user->roles = array();
    $user->roles[DRUPAL_AUTHENTICATED_RID] = 'authenticated user';
    $result = db_query("SELECT r.rid, r.name FROM {role} r INNER JOIN {users_roles} ur ON ur.rid = r.rid WHERE ur.uid = %d", $user->uid);
    while ($role = db_fetch_object($result)) {
      $user->roles[$role->rid] = $role->name;
    }
  }
  // We didn't find the client's record (session has expired), or they are an anonymous user.
  else {
    $session = isset($user->session) ? $user->session : '';
    $global_sid = isset($user->global_sid) ? $user->global_sid : '';
    $user = drupal_anonymous_user($session);
    $user->global_sid = $global_sid;
  }

  // Log the UID at the beginning of the request to catch log-in / log-out requests.
  sess_old_uid($user->uid);

  return $user->session;
}

function sess_write($key, $value, $domain = '', $global_sid = '', $nonce = '', $force = FALSE) {
  global $user;

  // If saving of session data is disabled or if the client doesn't have a session,
  // and one isn't being created ($value), do nothing. This keeps crawlers out of
  // the session table. This reduces memory and server load, and gives more useful
  // statistics. We can't eliminate anonymous session table rows without breaking
  // the throttle module and the "Who's Online" block.
  if (!$force && (!session_save_session() || ($user->uid == 0 && empty($_COOKIE[session_name()]) && empty($value)))) {
    return TRUE;
  }

  // Fill out SSO parameters for session if not supplied.
  if (!$domain) {
    $domain = singlesignon_get_domain();
  }
  if (!$global_sid) {
    $global_sid = isset($user->global_sid) ? $user->global_sid : '';
  }

  db_query("UPDATE {sessions} SET uid = %d, cache = %d, hostname = '%s', session = '%s', timestamp = %d, domain = '%s', global_sid = '%s', nonce = '%s' WHERE sid = '%s'", $user->uid, isset($user->cache) ? $user->cache : '', ip_address(), $value, time(), $domain, $global_sid, $nonce, $key);
  if (db_affected_rows()) {
    // If a UID change is made, delete all linked client sessions. This forces
    // the linked sessions to be recreated one by one on the next visit (to
    // regenerate their SIDs).
    if ($user->uid != sess_old_uid()) {
      singlesignon_destroy_client_sessions($key);
    }

    // Last access time is updated no more frequently than once every 180 seconds.
    // This reduces contention in the users table.
    if ($user->uid && time() - $user->access > variable_get('session_write_interval', 180)) {
      db_query("UPDATE {users} SET access = %d WHERE uid = %d", time(), $user->uid);
    }
  }
  else {
    // If this query fails, another parallel request probably got here first.
    // In that case, any session data generated in this request is discarded.
    @db_query("INSERT INTO {sessions} (sid, uid, cache, hostname, session, timestamp, domain, global_sid, nonce) VALUES ('%s', %d, %d, '%s', '%s', %d, '%s', '%s', '%s')", $key, $user->uid, isset($user->cache) ? $user->cache : '', ip_address(), $value, time(), $domain, $global_sid, $nonce);
  }

  return TRUE;
}

/**
 * Called when an anonymous user becomes authenticated or vice-versa.
 */
function sess_regenerate() {
  $old_session_id = session_id();

  // We code around http://bugs.php.net/bug.php?id=32802 by destroying
  // the session cookie by setting expiration in the past (a negative
  // value).  This issue only arises in PHP versions before 4.4.0,
  // regardless of the Drupal configuration.
  // TODO: remove this when we require at least PHP 4.4.0
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
  }

  session_regenerate_id();

  db_query("UPDATE {sessions} SET sid = '%s' WHERE sid = '%s'", session_id(), $old_session_id);
  db_query("UPDATE {sessions} SET global_sid = '%s' WHERE global_sid = '%s'", session_id(), $old_session_id);
}

/**
 * Counts how many users have sessions. Can count either anonymous sessions, authenticated sessions, or both.
 *
 * @param int $timestamp
 *   A Unix timestamp representing a point of time in the past.
 *   The default is 0, which counts all existing sessions.
 * @param int $anonymous
 *   TRUE counts only anonymous users.
 *   FALSE counts only authenticated users.
 *   Any other value will return the count of both authenticated and anonymous users.
 * @return  int
 *   The number of users with sessions.
 */
function sess_count($timestamp = 0, $anonymous = TRUE) {
  $query = $anonymous ? ' AND uid = 0' : ' AND uid > 0';
  return db_result(db_query('SELECT COUNT(sid) AS count FROM {sessions} WHERE timestamp >= %d'. $query, $timestamp));
}

/**
 * Called by PHP session handling with the PHP session ID to end a user's session.
 *
 * @param  string $sid
 *   the session id
 */
function sess_destroy_sid($sid) {
  singlesignon_destroy_controller_session($sid);

  db_query("DELETE FROM {sessions} WHERE sid = '%s'", $sid);

  singlesignon_destroy_client_sessions($sid);
}

/**
 * End a specific user's session
 *
 * @param  string $uid
 *   the user id
 */
function sess_destroy_uid($uid) {
  db_query('DELETE FROM {sessions} WHERE uid = %d', $uid);
}

function sess_gc($lifetime) {
  // Be sure to adjust 'php_value session.gc_maxlifetime' to a large enough
  // value. For example, if you want user sessions to stay in your database
  // for three weeks before deleting them, you need to set gc_maxlifetime
  // to '1814400'. At that value, only after a user doesn't log in after
  // three weeks (1814400 seconds) will his/her session be removed.
  db_query("DELETE FROM {sessions} WHERE timestamp < %d", time() - $lifetime);

  // Delete orphaned slave sessions.
  $result = db_query("SELECT a.sid FROM {sessions} a LEFT JOIN {sessions} b ON a.global_sid = b.sid WHERE a.global_sid <> '' AND b.sid IS NULL");
  while ($session = db_fetch_object($result)) {
    sess_destroy_sid($session->sid);
  }

  return TRUE;
}

/**
 * Determine whether to save session data of the current request.
 *
 * This function allows the caller to temporarily disable writing of session data,
 * should the request end while performing potentially dangerous operations, such as
 * manipulating the global $user object.  See http://drupal.org/node/218104 for usage
 *
 * @param $status
 *   Disables writing of session data when FALSE, (re-)enables writing when TRUE.
 * @return
 *   FALSE if writing session data has been disabled. Otherwise, TRUE.
 */
function session_save_session($status = NULL) {
  static $save_session = TRUE;
  if (isset($status)) {
    $save_session = $status;
  }
  return ($save_session);
}

/**
 * Helper function for retrieving the session domain from a URL.
 */
function singlesignon_get_domain($url = NULL) {
  global $base_url;
  if (!isset($url)) {
    $url = $base_url;
  }
  $parsed = parse_url($url);
  return preg_replace('/^www\./', '', $parsed['host']) . ($parsed['scheme'] == 'https' ? ':ssl' : '');
}

/**
 * Helper function for claiming a session using a nonce.
 */
function singlesignon_claim_session($nonce) {
  global $user;

  // Look up session by nonce.
  $sid = db_result(db_query("SELECT sid FROM {sessions} WHERE nonce = '%s'", $nonce));

  if ($sid) {
    // Wipe nonce from the DB.
    db_query("UPDATE {sessions} SET nonce = '' WHERE sid = '%s'", $sid);

    // Adopt the new session and give it a permanent SID.
    sess_destroy_sid(session_id());
    session_id($sid);
    sess_regenerate();

    // Don't overwrite the information in the adopted session.
    session_save_session(FALSE);

    return TRUE;
  }
  return FALSE;
}

/**
 * Helper function for deleting associated client sessions.
 */
function singlesignon_destroy_client_sessions($sid) {
  db_query("DELETE FROM {sessions} WHERE global_sid = '%s'", $sid);
}

/**
 * Helper function for deleting an associated controller session (and all its client sessions).
 */
function singlesignon_destroy_controller_session($sid) {
  $global_sid = db_result(db_query("SELECT global_sid FROM {sessions} WHERE sid = '%s'", $sid));
  if ($global_sid) {
    sess_destroy_sid($global_sid);
  }
}

/**
 * Helper function to track uid changes in page requests.
 */
function sess_old_uid($uid = NULL) {
  static $_uid = 0;
  if (!is_null($uid)) {
    $_uid = $uid;
  }
  return $_uid;
}
