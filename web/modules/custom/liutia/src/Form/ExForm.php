<?php

namespace Drupal\liutia\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InsertCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Symfony\Component\HttpFoundation\JsonResponse;


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

   $form['message2'] = [
     '#type' => 'markup',
     '#markup' => '<div class="result_email"></div>',
   ];

   $form['email'] = array(
     '#type' => 'email',
     '#title' => $this->t('Your email:'),
     '#description' => $this->t('Only A-Z, _ or -'),
     '#required' => TRUE,
     '#ajax' => [
       'callback' => '::setMessagea',
       'event' => 'keyup',
     ]
   );

   $form['message3'] = [
     '#type' => 'markup',
     '#markup' => '<div class="result_image"></div>',
   ];

   $form['image'] = [
     '#type' => 'managed_file',
     '#title' => t('Cat photo'),
     '#required' => TRUE,
     '#upload_validators' => array(
       'file_validate_extensions' => array('png jpg jpeg'),
       'file_validate_size' => array(2097152),
     ),
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

  public function setMessagea(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $email = $form_state->getValue('email');
    $is_email = preg_match("/^(?:[a-zA-Z]+(?:[-_]?[a-zA-Z]+)?@[a-zA-Z_-]+(?:\.?[a-zA-Z]+)?\.[a-z]{2,5})$/i", $email);

    if ($is_email> 0) {
      $response->addCommand(
        new HtmlCommand(
          '.result_email',
          '<div class="my_top_message">' . $this->t('You email: %title.', ['%title' => $email])
        )
      );
    }
    if ($is_email<= 0) {
      $response->addCommand(
        new HtmlCommand(
          '.result_email',
          '<div class="my_top_message">' . $this->t('Not correct email')
        )
      );
    }

    return $response;
  }

 public function setMessage(array $form, FormStateInterface $form_state) {
   $response = new AjaxResponse();
   $title = $form_state->getValue('title');
   $is_number = preg_match("/\w{2,32}/", $title, );
   if ($is_number <= 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_message',
         '<div class="my_top_message">' . $this->t('Not correct name')
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

   $email = $form_state->getValue('email');
   $is_email = preg_match("/^(?:[a-zA-Z]+(?:[-_]?[a-zA-Z]+)?@[a-zA-Z_-]+(?:\.?[a-zA-Z]+)?\.[a-z]{2,5})$/i", $email);

   if ($is_email> 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_email',
         '<div class="my_top_message">' . $this->t('You email: %title.', ['%title' => $email])
       )
     );
   }
   if ($is_email<= 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_email',
         '<div class="my_top_message">' . $this->t('Not correct email')
       )
     );
   }

   $image = $form_state->getValue('image');

   if ($image > 2097152) {
     $response->addCommand(
       new HtmlCommand(
         '.result_image',
         '<div class="my_top_message">' . $this->t('Not correct image')
       )
     );
   }
   if ($image <= 0) {
     $response->addCommand(
       new HtmlCommand(
         '.result_image',
         '<div class="my_top_message">' . $this->t('Not correct image')
       )
     );
   }
   if ($image == null) {
     $response->addCommand(
       new HtmlCommand(
         '.result_image',
         '<div class="my_top_message">' . $this->t('Not correct image')
       )
     );
   }




   return $response;
 }

 public function getFormId() {
   return 'liutia_exform_form';
 }

 public function submitForm(array &$form, FormStateInterface $form_state) {}
}
