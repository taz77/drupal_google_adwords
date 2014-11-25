<?php

/**
 * @file
 * Contains \Drupal\google_adwords\Form\GoogleAdwordsAdminSettings.
 */

namespace Drupal\google_adwords\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use \Drupal\user\RoleInterface;
use Drupal\Core\Session;
use Drupal\user\Entity\Role;

class GoogleAdwordsAdminSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'google_adwords_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('google_adwords.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  public function buildForm(array $form_state, \Drupal\Core\Form\FormStateInterface $form_state) {

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
    $form['conversion']['roles'] = array(
      '#type' => 'fieldset',
      '#title' => t('User Role Tracking'),
      '#collapsible' => TRUE,
      '#description' => t('Define what user roles should be tracked.'),
    );
    
    $prefix = 'user.role.';
    $cut = strlen($prefix);
    $result = \Drupal::service('config.storage')->listAll($prefix);
    
    foreach ($result as $role) {
      // Can't use empty spaces in varname.
      $rid = substr($role, $cut);
      $config = \Drupal::config("user.role.$rid");
      $role_name = $config->get('label');      
      $form['conversion']['roles']['google_adwords_track_' . $rid] = array(
        '#type' => 'checkbox',
        '#title' => t($role_name),
        '#default_value' => // @FIXME: &#039;google_adwords_track_&#039; . $role_varname must be added to your module's default configuration.
        \Drupal::config('google_adwords.settings')->get('google_adwords_track_' . $role_varname),
      );
    }

    return parent::buildForm($form, $form_state);
  }

}
