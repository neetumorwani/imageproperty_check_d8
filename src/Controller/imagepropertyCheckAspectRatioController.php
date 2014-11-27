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
    dsm('files managed ');dsm($files_managed);
    $query = db_select('file_usage');
    $query->fields('file_usage', array('fid', 'count'));
    $files_usage = $query->execute()->fetchAllKeyed();
    dsm('files usage'); dsm($files_usage);
    $list_image_style = image_style_options();
    unset($list_image_style['']);
    $original_all_images = file_scan_directory('public://', '/.*\.(png|jpg|JPG)$/');
    $options = array('min_depth' => 1);
    $original_subdirectory_images = file_scan_directory('public://', '/\.(png|jpg|JPG)$/', $options);
    $file_images = array_diff_key($original_all_images, $original_subdirectory_images);
    foreach ($list_image_style as $image_style => $value) {
      $image_info = "";
      $images = file_scan_directory('public://styles/' . $image_style, '/.*/');
      foreach ($images as $image_obj) {
        if (array_key_exists('public://' . $image_obj->filename, $file_images)) {
          $fid = $files_managed['public://' . $image_obj->filename];
          $usage_count = (isset($files_usage[$fid])) ? $files_usage[$fid] : 0;
          $orig_image_obj = Drupal::service('image.factory')->get('public://' . $image_obj->filename);
          $orig_width = $orig_image_obj->getWidth();
          $orig_height = $orig_image_obj->getHeight();
          $orig_aspect_ratio = $orig_width/$orig_height;
          $used_image_obj = Drupal::service('image.factory')->get($image_obj->uri);
          $used_width = $used_image_obj->getWidth();
          $used_height = $used_image_obj->getHeight();
          $used_aspect_ratio = $used_width/$used_height;
          if ($used_aspect_ratio > $orig_aspect_ratio) {
            $diff = ($used_aspect_ratio - $orig_aspect_ratio) * 100 / $orig_aspect_ratio;
          }
          else {
            $diff = ($orig_aspect_ratio - $used_aspect_ratio) * 100 / $orig_aspect_ratio;
          }
          if ($diff > 1 && $usage_count != 0) {
          db_insert('imageproperty_check_aspect_ratio')
          ->fields(array(
            'image_name' => $image_obj->name,
            'fid' => $fid,
            'usage_count' => $usage_count,
            'image_original_aspect_ratio' => $orig_aspect_ratio,
            'image_aspect_ratio' => $used_aspect_ratio,
            'image_diff' => $diff,
            'image_style' => $image_style,
            'image_path' => file_build_uri($image_obj->filename),
          ))->execute();
        }
        }

      }
    }
    return array(
    '#theme' => 'item_list',
    '#items' => array(1,2),
    );
  }
}
