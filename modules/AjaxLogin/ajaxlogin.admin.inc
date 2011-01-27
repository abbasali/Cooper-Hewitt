<?php
// $Id: ajaxlogin.admin.inc 316 2009-02-07 21:47:11Z lucky $

/**
 * @file
 * Administrative page callbacks for the ajaxlogin module.
 */

/**
 * Create a simple form for enabling or disabling Ajax login.
 */
function ajaxlogin_admin_settings() {
  
	// The container label
  $form['ajaxlogin_login_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Ajax Login settings')
  );
  
  // This is actually the setting. 
  $form['ajaxlogin_login_settings']['ajaxlogin_enabled'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Ajax login'),
    '#default_value' => variable_get('ajaxlogin_enabled', 0),
    '#description' => t('Automatically activate Ajax login for links to user/login.'),
  );

  return system_settings_form($form);

} // end of ajaxlogin_admin_settings
