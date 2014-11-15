<?php

/**
 * @file
 * Contains \Drupal\time_spent\Controller\timeSpentController.
 */

namespace Drupal\imageproperty_check\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;



class imagepropertyCheckController extends ControllerBase {

  public function __construct() {
    $this->database = \Drupal::database();

  }

  public function imagepropertyCheckReports() {
    return array(
      '#theme' => 'item_list',
      '#items' => array(1, 2),
    );
  }
}