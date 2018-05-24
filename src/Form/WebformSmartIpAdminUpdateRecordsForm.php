<?php

/**
 * @file
 * Contains \Drupal\webform_smart_ip\Form\WebformSmartIpAdminUpdateRecordsForm.
 */

namespace Drupal\webform_smart_ip\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class WebformSmartIpAdminUpdateRecordsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'webform_smart_ip_admin_update_records_form';
  }

  public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state) {
    // Define submit handler function

    // Container for manual lookup
    $form['webform_smart_ip_manual_lookup'] = [
      '#type' => 'fieldset',
      '#title' => t('Update existing form entries'),
      '#description' => t('Update forms submitted prior to Webform Smart IP installation'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    ];

    $allWebforms = webform_smart_ip_get_webforms_with_smart_ip_fields();

    $form['webform_smart_ip_manual_lookup']['form_to_process'] = [
      '#type' => 'select',
      '#title' => t('Which Form would you like to process?'),
      '#options' => $allWebforms,
      '#description' => t('Select the webform you would like to process.'),
      '#required' => TRUE,
      '#empty_option' => '--Webforms--',
    ];

    // Form for manual updating of the IP-Country database
    $form['webform_smart_ip_manual_lookup']['webform_smart_ip_lookup_button'] = [
      '#type' => 'submit',
      '#value' => t('Process Form'),
      '#submit' => [
        '_webform_smart_ip_lookup_submit'
        ],
      '#ajax' => ['callback' => '_webform_smart_ip_lookup_js'],
      '#suffix' => !$form_state->getStorage() ? '<div id="lookup-message" class="messages">' . $form_state->getStorage() . '</div>' : '',
    ];

    return $form;
  }

}
?>
