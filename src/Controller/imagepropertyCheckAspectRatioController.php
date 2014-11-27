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
    return array(
    '#theme' => 'item_list',
    '#items' => array(1,2),
    );
  }
}
