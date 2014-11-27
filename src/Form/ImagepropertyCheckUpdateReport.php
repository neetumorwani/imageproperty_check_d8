<?php

/**
 * @file
 * Contains \Drupal\time_spent\Form\TimeSpentConfigForm.
 */

namespace Drupal\imageproperty_check\Form;
use Drupal\Core\Form\ConfigFormBase;
//use Drupal\node\Entity\NodeType;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

class ImagepropertyCheckUpdateReport extends ConfigFormBase {
  public function getFormId() {
    return 'imageproperty_check_config_form';
  }
}