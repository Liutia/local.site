<?php

/**
 * @return
 * Contains \Drupal\nekromant512\Controller\FirstPageController.
 */
  
namespace Drupal\nekromant512\Controller;
  
/**
 * Provides route responses for the nekromant512 module.
 */
class FirstPageController {
  
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function content() {
    $element = array(
      '#markup' => 'Hello! You can add here a photo of your cat.',
    );
    return $element;
  }
  
}