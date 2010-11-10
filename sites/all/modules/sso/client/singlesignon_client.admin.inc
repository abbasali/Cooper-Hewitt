<?php
// $Id: singlesignon_client.admin.inc,v 1.1 2009/09/30 18:55:11 meba Exp $

/**
 * @file
 * Administration code for Single sign-on client.
 *
 * Manages the SSO client settings screen.
 */

/**
 * Menu callback: SSO configuration form.
 */
function singlesignon_client_admin_settings() {
  // Controller settings.
  $form['controller'] = array(
    '#type' => 'fieldset',
    '#title' => t('Controller settings'),
    '#description' => t("To link up this site with your single sign-on network, enter the following information from the Single sign-on controller adminstration screen."),
  );

  $form['controller']['singlesignon_client_controller_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Controller URL'),
    '#default_value' => variable_get('singlesignon_client_controller_url', ''),
    '#description' => t('Enter the fully qualified URL to your single sign-on controller site.'),
  );

  $form['controller']['singlesignon_client_private_key'] = array(
    '#type' => 'textfield',
    '#title' => t('Private key'),
    '#default_value' => variable_get('singlesignon_client_private_key', ''),
    '#description' => t('Paste the private key from your single sign-on controller site.'),
  );

  // Bot recognition settings.
  $form['bots'] = array(
    '#type' => 'fieldset',
    '#title' => t('Bot recognition'),
    '#description' => t("To avoid creating unnecessary single sign-on sessions, this module attempts to identify and ignore non-human clients. The following settings control the recognition rules. Only a single rule needs to match for a request to be ignored."),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['bots']['singlesignon_bot_names'] = array(
    '#type' => 'textarea',
    '#title' => t('User agents'),
    '#default_value' => variable_get('singlesignon_bot_names', SINGLESIGNON_BOT_NAMES),
    '#description' => t('Enter a list of keywords to identify user agents, each on its own line.'),
  );

  $form['bots']['singlesignon_bot_ips'] = array(
    '#type' => 'textarea',
    '#title' => t('IPs'),
    '#default_value' => variable_get('singlesignon_bot_ips', SINGLESIGNON_BOT_IPS),
    '#description' => t('Enter a list of IP addresses, each on its own line.'),
  );

  $form['bots']['singlesignon_bot_paths'] = array(
    '#type' => 'textarea',
    '#title' => t('Request paths'),
    '#default_value' => variable_get('singlesignon_bot_paths', SINGLESIGNON_BOT_PATHS),
    '#description' => t('Enter a list of paths to ignore, each on its own line.'),
  );

  $form['bots']['singlesignon_bot_regex'] = array(
    '#type' => 'textarea',
    '#title' => t('User agent (advanced)'),
    '#default_value' => variable_get('singlesignon_bot_regex', SINGLESIGNON_BOT_REGEX),
    '#description' => t('Enter an additional regular expression to match user agents against.'),
  );

  $form['#validate'][] = 'singlesignon_client_admin_settings_validate';

  return system_settings_form($form);
}

/**
 * Validate callback for SSO configuration form.
 */
function singlesignon_client_admin_settings_validate($form, &$form_state) {
  // Remove trailing slashes.
  $url = &$form_state['values']['singlesignon_client_controller_url'];
  $url = rtrim($url, '/');

  // Verify the URL is a root.
  $parsed = parse_url($url);
  if (isset($parsed['path']) || isset($parsed['query']) || isset($parsed['fragment'])) {
    form_set_error('singlesignon_client_controller_url', t('The controller URL must be at the root of a domain.'));
  }

  // Validate the bot regex.
  if (!singlesignon_client_validate_regex($form_state['values']['singlesignon_bot_regex'])) {
    form_set_error('singlesignon_bot_regex', t('The user agent regular expression is invalid.'));
  }
}

/**
 * Helper function for validating a PCRE regex.
 */
function singlesignon_client_validate_regex($regex) {
  return is_int(@preg_match($regex, ''));
}
