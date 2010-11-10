<?php
// $Id: singlesignon.inc,v 1.1 2009/09/30 18:55:11 meba Exp $

/**
 * Enable logging of SSO transactions?
 */
define('SSO_DEBUG', false);

/**
 * Log file path/prefix.
 */
define('SSO_DEBUG_LOG', '/tmp/sso-log-');

/**
 * @file
 * Shared utility code for SSO purposes.
 *
 * Checks shared requirements, contains schema changes and handles signed GET requests.
 */

/**
 * Delegate for hook_requirements().
 */
function _singlesignon_requirements($phase) {
  if ($phase == 'runtime') {
    // Verify that session.inc was replaced.
    $requirements['singlesignon handler'] = array(
      'title' => t('Single sign-on handler'),
    );
    $path = dirname(drupal_get_path('module', 'singlesignon_controller')) .'/session.singlesignon.inc';

    if (variable_get('session_inc', '') == $path) {
      $requirements['singlesignon handler'] += array(
        'severity' => REQUIREMENT_OK,
        'value' => t('Installed'),
      );
    }
    else {
      $requirements['singlesignon handler'] += array(
        'severity' => REQUIREMENT_ERROR,
        'value' => t('Not installed'),
        'description' => t('Please add the following line to %settings:', array('%settings' => conf_path() .'/settings.php')) ."<br /><code>\$conf['session_inc'] = ". check_plain(var_export($path, 1)) .";</code>",
      );
    }
    return $requirements;
  }
  elseif ($phase == 'install') {
    // Verify the site is at the root of a domain.
    global $base_url;
    $parsed = parse_url($base_url);
    if (isset($parsed['path'])) {
      $requirements['singlesignon subdirectory'] = array(
        'title' => t('Base URL'),
        'value' => check_plain($base_url),
        'description' => t('Single sign-on does not support sites running in a subdirectory.'),
        'severity' => REQUIREMENT_ERROR,
      );
    }
  }
}

/**
 * Delegate for hook_schema_alter().
 */
function _singlesignon_schema_alter(&$schema) {
  // Add additional SSO fields to the sessions table.
  $schema['sessions']['fields'] += array(
    'domain' => array(
      'type' => 'varchar',
      'length' => 128,
      'not null' => TRUE,
      'default' => ''),
    'global_sid' => array(
      'type' => 'varchar',
      'length' => 64,
      'not null' => TRUE,
      'default' => ''),
    'nonce' => array(
      'type' => 'varchar',
      'length' => 64,
      'not null' => TRUE,
      'default' => ''),
  );
  $schema['sessions']['indexes'] += array(
    'nonce' => array('nonce'),
    'global_sid' => array('global_sid'),
  );
}

/**
 * Generate a short-term random token.
 */
function singlesignon_get_random_id() {
  list($nonce) = unpack('H*0', singlesignon_drupal_random_bytes(8));
  return $nonce;
}

/**
 * Return an HMAC for a given base URL + arguments.
 */
function singlesignon_hmac($base_url, $arguments, $key) {
  // Prepare consistent, order-independent, site-specific message.
  ksort($arguments);
  $message = array();
  $message[] = $base_url;
  $message[] = implode(':', array_keys($arguments));
  $message[] = implode(':', array_values($arguments));
  $message = implode(',', $message);

  // HMAC-RIPEMD-160-96
  return substr(hash_hmac('ripemd160', $message, $key), 0, 24);
}

/**
 * Generate a signed SSO request.
 *
 * Because some user agents (e.g. crawlers) might alter the request URI, we cannot
 * HMAC the URL as a single piece of data. Instead we hash the base URL + the
 * query arguments (including the page path), as if clean URLs were off.
 */
function singlesignon_create_request($base_url, $path, $arguments, $key) {

  // Generate HMAC from arguments.
  if ($_SESSION['singlesignon_message']) {
    $arguments['singlesignon_message'] = $_SESSION['singlesignon_message'];
  }
  $hmac = singlesignon_hmac($base_url, array('q' => $path) + $arguments, $key);


  // Cannot use drupal_query_string_encode(). Drupal 6 applies mod_rewrite
  // workaround on query arguments unnecessarily.
  $query = singlesignon_build_query($arguments);

  // Compose regular Drupal URL.
  $url = $base_url . url($path, array('query' => $query));

  // Append HMAC to GET URL.
  return $url . (strpos($url, '?') !== FALSE ? '&' : '?') .'auth='. $hmac;
}

function singlesignon_build_query($arguments) {
  $query = array();
  foreach ($arguments as $key => $value) {
    $query[] = urlencode($key) .'='. urlencode($value);
  }
  $query = implode('&', $query);

  return $query;
}

/**
 * Verify if the current request is signed correctly.
 */
function singlesignon_verify_request($key) {
  global $base_url;

  // Verify if an auth token was set.
  if (!isset($_GET['auth'])) {
    return FALSE;
  }

  // Construct list of arguments.
  $arguments = $_GET;
  unset($arguments['auth']);

  // Generate auth token.
  $hmac = singlesignon_hmac($base_url, $arguments, $key);

  // Verify HMAC.
  return $hmac == $_GET['auth'];
}

/**
 * Redirect to a given absolute URL.
 */
function singlesignon_goto($url) {
  global $base_url;
  // Ensure all session data is written.
  session_write_close();
  header('Location: '. ($url ? $url : $base_url));
}

/**
 * Returns a string of highly randomized bytes (over the full 8-bit range).
 *
 * (straight backport from Drupal 7)
 *
 * This function is better than simply calling mt_rand() or any other built-in
 * PHP function because it can return a long string of bytes (compared to < 4
 * bytes normally from mt_rand()) and uses the best available pseudo-random source.
 *
 * @param $count
 *   The number of characters (bytes) to return in the string.
 */
function singlesignon_drupal_random_bytes($count)  {
  static $random_state;
  // We initialize with the somewhat random PHP process ID on the first call.
  if (empty($random_state)) {
    $random_state = getmypid();
  }
  $output = '';
  // /dev/urandom is available on many *nix systems and is considered the best
  // commonly available pseudo-random source.
  if ($fh = @fopen('/dev/urandom', 'rb')) {
    $output = fread($fh, $count);
    fclose($fh);
  }
  // If /dev/urandom is not available or returns no bytes, this loop will
  // generate a good set of pseudo-random bytes on any system.
  // Note that it may be important that our $random_state is passed
  // through md5() prior to being rolled into $output, that the two md5()
  // invocations are different, and that the extra input into the first one -
  // the microtime() - is prepended rather than appended.  This is to avoid
  // directly leaking $random_state via the $output stream, which could
  // allow for trivial prediction of further "random" numbers.
  while (strlen($output) < $count) {
    $random_state = md5(microtime() . mt_rand() . $random_state);
    $output .= md5(mt_rand() . $random_state, TRUE);
  }
  return substr($output, 0, $count);
}

/**
 * Helper function for debugging SSO transactions.
 *
 * Clients are identified by address and browser fingerprint, data is logged
 * to SSO_DEBUG_LOG.
 */
function singlesignon_log($data = array()) {
  global $user, $base_url;

  $o = date('c') ."\n";
  foreach ($data as $k => $v) {
    $o .= "$k: $v\n";
  }
  $o .= "Request: ". $base_url . request_uri() ."\n";
  $o .= "Referrer: ". referer_uri() ."\n";
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $o .= "User agent: ". $_SERVER['HTTP_USER_AGENT'] ."\n";
  }
  if (isset($_SERVER['REMOTE_ADDR'])) {
    $o .= "Remote Address: ". $_SERVER['REMOTE_ADDR'] ."\n";
  }
  $o .= "Cookies: ". print_r($_COOKIE, 1) ."\n";
  $o .= "Old SID: ". (isset($user->sid) ? $user->sid : '<none>') ."\n";
  $o .= "Old Global SID: ". (isset($user->global_sid) ? $user->global_sid : '<none>') ."\n";
  $o .= "New SID: ". (session_id()) ."\n";
  $o .= "New Global SID: ". (db_result(db_query("SELECT global_sid FROM {sessions} WHERE sid = '%s'", session_id()))) ."\n";
  $o .= "Domain: ". (isset($user->domain) ? $user->domain : '<none>') ."\n";

  $id = substr(md5($_SERVER['HTTP_ACCEPT_LANGUAGE'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']), 0, 6);
  $f = fopen(SSO_DEBUG_LOG . $id, 'a+');
  fwrite($f, $o ."--------------------------------------------------------------------------------\n");
  fclose($f);
}
