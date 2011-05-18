<?php
/**
 * @file
 * Redirected page callback file for the protected_node module.
 * This version supports any number of pages instead of a destination.
 */

/**
 * Transforms the $_GET['protected_pages'] in a valid list
 * of $nids. Anything that is not valid we ignore. If there
 * isn't at least 1 then the function generates an access
 * denied error and exits.
 *
 * @return The array of nids.
 */
function protected_node_password_nids()
{
  $nids = array();
  $nids_list = explode(',', $_GET['protected_pages']);
  foreach ($nids_list as $nid) {
    $nid = trim($nid);
    if (is_numeric($nid)) {
      $nids[] = $nid;
    }
  }

  // make sure we have at least one destination otherwise there is no password to check
  if (count($nids) == 0) {
    // Illegal call
    watchdog('protected_node', 'Illegal call to /protected-node', array(), WATCHDOG_WARNING);
    drupal_access_denied();
    exit();
  }

  return $nids;
}

/**
 * Create the form asking the end users for the node password.
 *
 * The function expects a $_GET with the variable named protected_pages.
 * This parameter is a list of comma separated NIDs.
 *
 * The function accepts a $_GET named 'back'. This is a URL used for the
 * Cancel link shown next to the OKAY button.
 *
 * @important
 * The function does NOT use check_plain() on the $info, $description,
 * etc. because the administrator is the only one who can enter that
 * information.
 *
 * @todo
 * It would be a good idea to transform this function in a theme() call instead.
 */
function protected_node_enter_any_password() {
  global $user;

  if (isset($_GET['destination'])) {
    // Illegal call
    watchdog('protected_node', 'Illegal call to /protected-nodes', array(), WATCHDOG_WARNING);
    drupal_access_denied();
    exit();
  }

  $nids = protected_node_password_nids();

  // check, in reverse order, whether a node password was specified;
  // if so, use that node
  foreach (array_reverse($nids) as $nid) {
    if (!empty($_SESSION['_protected_node']['passwords'][$nid])) {
      $when = $_SESSION['_protected_node']['passwords'][$nid];
      if ($when > variable_get('protected_node_session_timelimit', 0)) { // global reset time
        $node = node_load($nid);
        if ($when > $node->protected_node_passwd_changed) {  // this page reset time
          // the password is still known, go to the page
          drupal_goto('node/' . $nid);
        }
      }
      // if the "best" node had a password and it's gone, we don't test the
      // other pages; instead we accept this one as is...
      break;
    }
  }

  // make sure the first node exists, the others we don't care as much at this point
  // they are tested when the user submits the password and used as the destination
  $node = node_load($nids[0]);
  if (!is_object($node)) {
    // Illegal nid
    watchdog('protected_node', 'Illegal nids[0] (@nid) to /protected-node', array('@nid' => $nids[0]), WATCHDOG_WARNING);
    drupal_access_denied();
    exit();
  }

  // some variable initialization
  $types = node_get_types();
  $node_type = $types[$node->type];
  $has_token = module_exists('token');

  // setup the title of this page
  $title = variable_get('protected_node_title', NULL);
  if (!empty($title)) {
    if ($has_token) {
      $title = token_replace($title, 'node', $node);
      $title = token_replace($title, 'user', $user);
    }
    drupal_set_title($title);
  }

  // information appear between the title and the password form
  $info = variable_get('protected_node_info', '');
  if ($has_token) {
    $info = token_replace($info, 'node', $node);
    $info = token_replace($info, 'user', $user);
  }
  $form['protected_node'] = array(
    '#value' => $info,
  );

  // enter the detailed description of the protected node password
  $description = variable_get('protected_node_description', '');
  if (!$description) {
    // TODO: this needs to move to {protected_node} and be loaded along the other information
    // in this case we assume the user may not have the token module
    // so we do conversions of the node type and title "by hand"
    $node_title = variable_get('protected_node-'. $node->nid .'-show_title', FALSE);
    if ($node_title) {
      // embellish the title with double quotes
      $node_title = '"' . $node_title . '"';
    }
    $description = t('The @node_type @node_title you are trying to view is password protected. Please enter the password below to proceed.',
                     array('@node_type' => $node_type->name, '@node_title' => $node_title));
  }
  elseif ($has_token) {
    $description = token_replace($description, 'node', $node);
    $description = token_replace($description, 'user', $user);
  }
  $form['protected_node_enterpassword'] = array(
    '#type' => 'fieldset',
    '#description' => $description,
    '#collapsible' => FALSE
  );

  // create the password widget
  $label = variable_get('protected_node_password_label', '');
  if ($label) {
    $label = token_replace($label, 'node', $node);
    $label = token_replace($label, 'user', $user);
  }
  else {
    $label = t('@node_type password', array('@node_type' => $node_type->name));
  }
  $form['protected_node_enterpassword']['password'] = array(
    '#type' => 'password',
    '#title' => $label,
    '#size' => 20
  );

  // the node we're working on
  //$form['protected_node_nid'] = array(
  //  '#type' => 'hidden',
  //  '#value' => implode(',', $nids);
  //);

  // add a submit button
  $form['protected_node_enterpassword']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('OK'),
  );

  // add a cancel link when 'back' is defined (i.e. referer on the previous page)
  if (isset($_GET['back'])) {
    $cancel = $_GET['back'];
  }
  elseif (variable_get('protected_node_cancel', 0)) {
    $cancel = '<front>';
  }
  if ($cancel) {
    $form['protected_node_enterpassword']['cancel'] = array(
      '#value' => l('Cancel', $cancel),
    );
  }

  return $form;
}

/**
 * Verify that the user entered the correct password.
 *
 * @note
 * It is correct that the list of nids is a hidden widget and thus it
 * may be tempered with by a hacker. This doesn't matter since we
 * check the password against those and if it is incorrect then the
 * user will simply be sent back to protected page and back to the
 * protected-node page.
 *
 * @param[in] $form  An array representing the protected node form.
 * @param[in,out] $form_state  An array representing the current state of the form.
 */
function protected_node_enter_any_password_validate($form, &$form_state) {
  // TODO: we do not want to check the global password if there is a local
  //       password (i.e. extract local password instead of comparing!)
  $nids = protected_node_password_nids();

  $sql = "SELECT nid FROM {protected_nodes} WHERE protected_node_passwd = '%s'"
        . " AND nid IN (" . db_placeholders($nids, 'int') . ")";
  $passwd = sha1($form['#post']['password']);
  $nid = db_result(db_query_range($sql, array_merge(array($passwd), $nids), 0, 1));
  if (empty($nid)) {
    // note that global password cannot work here since we wouldn't know where
    // to send the user otherwise
    form_set_error('password', t('Incorrect password!'));
  }
  else {
    $form_state['values']['protected_node_selected_nid'] = $nid;
  }
}

/**
 * Allow the user to see this node.
 */
function protected_node_enter_any_password_submit($form, &$form_state) {
  // switch the session to the newly unlocked page
  $nids = protected_node_password_nids();
  $nid = $form_state['values']['protected_node_selected_nid'];
  foreach ($nids as $n) {
    if ($n == $nid) {
      $_SESSION['_protected_node']['passwords'][$n] = time();
    }
    else {
      unset($_SESSION['_protected_node']['passwords'][$n]);
    }
  }
  drupal_goto('node/' . $nid);
}

// vim: ts=2 sw=2 et syntax=php
