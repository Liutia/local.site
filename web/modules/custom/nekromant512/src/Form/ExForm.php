<?php

namespace Drupal\nekromant512\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InsertCommand;
use Drupal\Core\Form\FormBase;                   // Базовый класс Form API
use Drupal\Core\Form\FormStateInterface;              // Класс отвечает за обработку данных
use Drupal\Core\Ajax\AjaxResponse;



/**
 * @see \Drupal\Core\Form\FormBase
 */

class ExForm extends FormBase {

 public function buildForm(array $form, FormStateInterface $form_state) {
   $form['text']['#markup'] = 'Hello! You can add here a photo of your cat.';
   $form['message'] = [
     '#type' => 'markup',
     '#markup' => '<div class="result_message"></div>',
   ];

   $form['title'] = [
     '#type' => 'textfield',
     '#title' => $this->t('Your cat’s name:'),
     '#description' => $this->t('Name: 2-32 letters'),
     '#required' => TRUE,
     '#maxlength' => 32,
     ];

   $form['action'] = [
     '#type' => 'submit',
     '#value' => $this->t('Add cat'),
     '#ajax' => [
       'callback' => '::setMessage',
     ]
   ];

   return $form;
 }

 public function setMessage(array $form, FormStateInterface $form_state) {
   $response = new AjaxResponse();
   $title = $form_state->getValue('title');
   $is_number = preg_match("/\w{2,32}/", $title, );
   if ($is_number <= 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_message',
         '<div class="my_top_message">' . $this->t('You cat name no correct')
       )
     );
   }
   if ($is_number > 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_message',
         '<div class="my_top_message">' . $this->t('You cat name: %title.', ['%title' => $title])
       )
     );
   }
   return $response;
 }

 public function getFormId() {
   return 'nekromant512_exform_form';
 }

 public function submitForm(array &$form, FormStateInterface $form_state) {}
}
