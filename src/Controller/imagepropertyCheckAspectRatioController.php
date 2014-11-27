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


class imagepropertyCheckAspectRatioController extends ControllerBase {

  public function __construct() {
    $this->database = Drupal::database();
  }

  public function imagepropertyCheckAspectRatioReports() {
    $form = \Drupal::formBuilder()->getForm('Drupal\imageproperty_check\Form\ImagepropertyCheckUpdateAspectRatioImages');
    $form_render = drupal_render($form);
    $query = db_select('file_managed');
    $query->fields('file_managed', array('uri', 'fid'))
          ->condition('file_managed.filemime', '%image%','LIKE');
    $files_managed = $query->execute()->fetchAllKeyed();
    $query = db_select('file_usage');
    $query->fields('file_usage', array('fid', 'count'));
    $files_usage = $query->execute()->fetchAllKeyed();
    $list_image_style = image_style_options();
    unset($list_image_style['']);
    $original_all_images = file_scan_directory('public://', '/.*\.(png|jpg|JPG)$/');
    $options = array('min_depth' => 1);
    $original_subdirectory_images = file_scan_directory('public://', '/\.(png|jpg|JPG)$/', $options);
    $file_images = array_diff_key($original_all_images, $original_subdirectory_images);
    dsm('file images'); dsm($file_images);
    foreach ($list_image_style as $image_style => $value) {
      $image_info = "";
      $images = file_scan_directory('public://styles/' . $image_style, '/.*/');
      dsm($images);
      foreach ($images as $image_obj) {
        if (array_key_exists('public://' . $uri->filename, $file_images)) {
          dsm('yes');
        }

      }
    }
    return array(
    '#theme' => 'item_list',
    '#items' => array(1,2),
    );
  }
}
