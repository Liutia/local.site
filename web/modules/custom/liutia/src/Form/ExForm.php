<?php

namespace Drupal\liutia\Form;

use Drupal\Core\Form\FormBase;                   // Базовый класс Form API
use Drupal\Core\Form\FormStateInterface;              // Класс отвечает за обработку данных

/**
 * Наследуемся от базового класса Form API
 * @see \Drupal\Core\Form\FormBase
 */
class ExForm extends FormBase {

 public function buildForm(array $form, FormStateInterface $form_state) {

  $form['text']['#markup'] = 'Hello! You can add here a photo of your cat.';

  $form['title'] = [
   '#type' => 'textfield',
   '#title' => $this->t('Your cat’s name:'),
   '#description' => $this->t('Name: 2-32 letters'),
   '#required' => TRUE,
   '#maxlength' => 32,
  ];

  // Add a submit button that handles the submission of the form.
  $form['actions']['submit'] = [
   '#type' => 'submit',
   '#value' => $this->t('Add cat'),
  ];

  return $form;
 }

 // метод, который будет возвращать название формы
 public function getFormId() {
  return 'liutia_exform_form';
 }

 // ф-я валидации
 public function validateForm(array &$form, FormStateInterface $form_state) {
  $title = $form_state->getValue('title');
  $is_number = preg_match("/\w{2,32}/", $title, $match);
  if ($is_number <= 0) {
   $form_state->setErrorByName('title', $this->t('Error'));
  }
 }

 // действия по сабмиту
 public function submitForm(array &$form, FormStateInterface $form_state) {
  $title = $form_state->getValue('title');
  \Drupal::messenger()->addMessage(t('You cat name: %title.', ['%title' => $title]));
 }
}
