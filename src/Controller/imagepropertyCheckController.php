<?php

/**
 * @file
 * Contains \Drupal\time_spent\Controller\timeSpentController.
 */

namespace Drupal\imageproperty_check\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Url;



class imagepropertyCheckController extends ControllerBase {

  public function __construct() {
    $this->database = \Drupal::database();
    $this->imageproperty_check_config = \Drupal::config('imageproperty_check.settings');

  }

  public function imagepropertyCheckReports() {
    $form = \Drupal::formBuilder()->getForm('Drupal\imageproperty_check\Form\ImagepropertyCheckRunCron');
    $list_image_style = image_style_options();
    unset($list_image_style['']);
    foreach ($list_image_style as $key => $value) {
      $images = file_scan_directory('public://styles/' . $key, '/.*/');
      $imageproperty_check_value = $this->imageproperty_check_config->get('imageproperty_check_type_'.$key);
      dsm($imageproperty_check_value);
    }
    return array(
      '#theme' => 'item_list',
      '#items' => array(1, 2),
    );
  }
}