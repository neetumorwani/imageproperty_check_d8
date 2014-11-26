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
    db_delete('imageproperty_check')
     ->execute();
    $list_image_style = image_style_options();
    unset($list_image_style['']);
    foreach ($list_image_style as $key => $value) {
      $images = file_scan_directory('public://styles/' . $key, '/.*/');
      $imageproperty_check_value = $this->imageproperty_check_config->get('imageproperty_check_type_'.$key);
      if ($imageproperty_check_value != 0) {
      foreach ($images as $image_obj) {
        $uri = $image_obj->uri;
        $image = Drupal::service('image.factory')->get($uri);
        $image_name = $image_obj->name;
        $image_path = $image_obj->uri;
        $image_filename = $image_obj->filename;
        $image_size_bs = $image->getFileSize();
        $image_size = ($image_size_bs) / 1000;
        if ($image_size > $imageproperty_check_value) {
          $this->database->insert('imageproperty_check')
          ->fields(array(
            'image_name' => $image_name,
            'image_size' => $image_size_bs,
            'image_path' => $image_path,
            'image_filename' => $image_filename,
          ))
          ->execute();
        }
      }
    }

    }
    return array(
      '#theme' => 'item_list',
      '#items' => array(1, 2),
    );
  }
}