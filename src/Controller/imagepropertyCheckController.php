<?php

/**
 * @file
 * Contains \Drupal\time_spent\Controller\timeSpentController.
 */

namespace Drupal\imageproperty_check\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Url;
use Drupal;


class imagepropertyCheckController extends ControllerBase {

  public function __construct() {
    $this->database = Drupal::database();
    $this->imageproperty_check_config = Drupal::config('imageproperty_check.settings');

  }

  public function imagepropertyCheckReports() {
    $form = Drupal::formBuilder()->getForm('Drupal\imageproperty_check\Form\ImagepropertyCheckRunCron');
    $list_image_style = image_style_options();
    unset($list_image_style['']);
    foreach ($list_image_style as $key => $value) {
      $images = file_scan_directory('public://styles/' . $key, '/.*/');
      $imageproperty_check_value = $this->imageproperty_check_config->get('imageproperty_check_type_'.$key);
      if ($imageproperty_check_value != 0) {
      foreach ($images as $image_obj) {
        $uri = $image_obj->uri;
        $image = Drupal::service('image.factory')->get($uri);
        $image_size_kbs = $image->getFileSize());
        // $image_size = ($image_info['file_size']) / 1000;
        // if ($image_size > $imageproperty_check_type) {
        //   db_insert('imageproperty_check')
        //     ->fields(array(
        //       'image_name' => $uri->name,
        //       'image_size' => $image_info['file_size'],
        //       'image_path' => $uri->uri,
        //       'image_filename' => $uri->filename,
        //     ))->execute();
        // }
      }
    }

    }
    return array(
      '#theme' => 'item_list',
      '#items' => array(1, 2),
    );
  }
}