<?php

/**
 * @file
 * Contains \Drupal\time_spent\Form\TimeSpentConfigForm.
 */

namespace Drupal\imageproperty_check\Form;
use Drupal\Core\Form\ConfigFormBase;
//use Drupal\node\Entity\NodeType;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

class ImagepropertyCheckUpdateReport extends FormBase {
  public function getFormId() {
    return 'imageproperty_check_update';
  }

  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $form = array();
    $form['actions']['update_report'] = array(
      '#type' => 'submit',
      '#value' => t('Update Image size and Aspect Ratio Report'),
      '#submit' => array('imageproperty_check_update_reports'),
    );
    $form['actions']['run_cron_manually'] = array(
      '#type' => 'button',
      '#value' => t('Run cron to recieve emails regarding images with glitches'),
      '#submit' => array('imageproperty_check_run_cron'),
      '#executes_submit_callback' => array(TRUE)  ,
    );

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    dsm('in first');
    $imagepropertyCheckController = new \Drupal\imageproperty_check\Controller\imagepropertyCheckController();
    $imagepropertyCheckController->imagepropertyCheckReports();
     // \Drupal\imageproperty_check\Controller\imagepropertyCheckController::imagepropertyCheckAspectRatioReports();
    $imagepropertyCheckAspectRatioController = new \Drupal\imageproperty_check\Controller\imagepropertyCheckAspectRatioController();
    $imagepropertyCheckAspectRatioController->imagepropertyCheckAspectRatioReports();

   // return TRUE;
    //return new RedirectResponse(\Drupal::url('system.run_cron'));
  }


  public function imageproperty_check_run_cron(array &$form, FormStateInterface $form_state) {
    dsm(' yay');
    $form_state->setRedirect('system.run_cron');
  }
}