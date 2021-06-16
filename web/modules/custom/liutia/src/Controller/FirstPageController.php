<?php

/**
 * @return
 * Contains \Drupal\liutia\Controller\FirstPageController.
 */
  
namespace Drupal\liutia\Controller;
  
/**
 * Provides route responses for the liutia module.
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