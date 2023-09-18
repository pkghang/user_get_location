<?php

namespace Drupal\user_get_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a configuration form for user_get_location settings.
 */
class LocationConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'user_get_location.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('user_get_location.settings');
    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#required' => TRUE,
      '#size' => 60,
      '#default_value' => $config->get('country'),
      '#maxlength' => 128,
      '#wrapper_attributes' => ['class' => 'col-md-6 col-xs-12'],
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#size' => 60,
      '#default_value' => $config->get('city'),
      '#wrapper_attributes' => ['class' => 'col-md-6 col-xs-12'],
    ];
    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('Time Zone'),
      '#options' => [
        'America/Chicago' => t('America/Chicago'),
        'America/New_York' => t('America/New_York'),
        'Asia/Tokyo' => t('Asia/Tokyo'),
        'Asia/Dubai' => t('Asia/Dubai'),
        'Asia/Kolkata' => t('Asia/Kolkata'),
        'Europe/Amsterdam' => t('Europe/Amsterdam'),
        'Europe/Oslo' => t('Europe/Oslo'),
        'Europe/London' => t('Europe/London'),
      ],
      '#default_value' => $config->get('timezone'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validation logic can be added here if needed.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('user_get_location.settings');
    $config->set('country', $form_state->getValue('country'));
    $config->set('city', $form_state->getValue('city'));
    $config->set('timezone', $form_state->getValue('timezone'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
