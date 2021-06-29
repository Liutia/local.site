<?php

namespace Drupal\liutia\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\file\Entity\File;

/**
 * Contains \Drupal\liutia\Form\CatForm.
 *
 * @file
 */

/**
 * Provides an Cat form.
 */
class CatChangeForm extends FormBase {

  /**
   * Contain slug id to edit cat entry.
   *
   * @var ctid
   */
  protected $ctid = 0;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cat_change_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];
    $form['name'] = [
      '#title' => t("Your cat's name:"),
      '#type' => 'textfield',
      '#size' => 32,
      '#description' => t("Name should be at least 2 characters and less than 32 characters"),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateAjax',
        'event' => 'keyup',
      ],
    ];
    $form['message2'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_email"></div>',
    ];
    $form['email'] = [
      '#title' => t("Email:"),
      '#type' => 'email',
      '#description' => t("example@gmail.com"),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::validateAjax',
        'event' => 'keyup',
      ],
    ];
    $form['message3'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_image"></div>',
    ];
    $form['image'] = [
      '#title' => t("Image:"),
      '#type' => 'managed_file',
      '#upload_location' => 'public://module-images',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
      '#description' => t("insert image below size of 2MB. Supported formats: png jpg jpeg."),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Edit cat'),
      '#ajax' => [
        'callback' => '::ajaxForm',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
        ],
      ],
    ];
    $this->ctid = $cid;
    return $form;
  }
  /**
   * Function that validate email and name input with ajax.
   */
  public function validateAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $name = $form_state->getValue('name');
    $is_number =  preg_match('/\w{2,32}/', $name);
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
          '<div class="my_top_message">' . $this->t('You cat name: %name.', ['%name' => $name])
        )
      );
    }

    $email = $form_state->getValue('email');
    $is_email = preg_match("/^(?:[a-zA-Z]+(?:[-_]?[a-zA-Z]+)?@[a-zA-Z_-]+(?:\.?[a-zA-Z]+)?\.[a-zA-Z]{2,5})/i", $email);

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

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $connection = \Drupal::service('database');
    $file = File::load($form_state->getValue('image')[0]);
    $file->setPermanent();
    $file->save();
    $result = $connection->update('liutia')
      ->condition('id', $this->ctid)
      ->fields([
        'name' => $form_state->getValue('name'),
        'mail' => $form_state->getValue('email'),
        'image' => $form_state->getValue('image')[0],
      ])
      ->execute();
  }

  /**
   * Function to redirect page.
   */
  public function ajaxForm(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(new RedirectCommand('/liutia/cats'));
    return $response;
  }

}
