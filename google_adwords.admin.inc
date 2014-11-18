<?php

/**
 * @file
 * Admin page for Google Adwords.
 */

/**
 * Admin settings page handler callback function.
 */
function google_adwords_admin_settings($form_state) {

  $form['conversion'] = array(
    '#type' => 'fieldset',
    '#title' => t('Default Conversion settings'),
    '#collapsible' => FALSE,
  );

  $form['conversion']['google_adwords_conversion_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Conversion ID'),
    '#default_value' => \Drupal::config('google_adwords.settings')->get('google_adwords_conversion_id'),
    '#size' => 15,
    '#maxlength' => 255,
    '#required' => FALSE,
    '#description' => '',
  );
  $form['conversion']['google_adwords_conversion_language'] = array(
    '#type' => 'textfield',
    '#title' => t('Conversion Language'),
    '#default_value' => \Drupal::config('google_adwords.settings')->get('google_adwords_conversion_language'),
    '#size' => 15,
    '#maxlength' => 255,
    '#required' => TRUE,
    '#description' => '',
  );
  $form['conversion']['google_adwords_conversion_format'] = array(
    '#type' => 'textfield',
    '#title' => t('Conversion Format'),
    '#default_value' => \Drupal::config('google_adwords.settings')->get('google_adwords_conversion_format'),
    '#size' => 15,
    '#maxlength' => 255,
    '#required' => TRUE,
    '#description' => '',
  );
  $form['conversion']['google_adwords_conversion_color'] = array(
    '#type' => 'textfield',
    '#title' => t('Conversion Color'),
    '#default_value' => \Drupal::config('google_adwords.settings')->get('google_adwords_conversion_color'),
    '#size' => 15,
    '#maxlength' => 255,
    '#required' => TRUE,
    '#description' => '',
  );
  $form['conversion']['google_adwords_external_script'] = array(
    '#type' => 'textfield',
    '#title' => t('External JavaScript'),
    '#default_value' => \Drupal::config('google_adwords.settings')->get('google_adwords_external_script'),
    '#size' => 80,
    '#maxlength' => 255,
    '#required' => TRUE,
    '#description' => '',
  );
  // Render the role overview.
  $result = db_query('SELECT * FROM {role} ORDER BY name');

  $form['conversion']['roles'] = array(
    '#type' => 'fieldset',
    '#title' => t('User Role Tracking'),
    '#collapsible' => TRUE,
    '#description' => t('Define what user roles should be tracked.'),
  );

  foreach ($result as $role) {
    // Can't use empty spaces in varname.
    $role_name = $role->name;
    $role_varname = str_replace(' ', '_', $role_name);
    $form['conversion']['roles']['google_adwords_track_' . $role_varname] = array(
      '#type' => 'checkbox',
      '#title' => t($role_name),
      '#default_value' => // @FIXME: &#039;google_adwords_track_&#039; . $role_varname must be added to your module's default configuration.
\Drupal::config('google_adwords.settings')->get('google_adwords_track_' . $role_varname),
    );
  }

  return system_settings_form($form);
}
