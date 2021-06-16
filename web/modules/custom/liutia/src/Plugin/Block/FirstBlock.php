<?php

namespace Drupal\liutia\Plugin\Block;
  
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
  
/**
 * Provides a block with a simple text.
 *
 * @block(
 *   id = "liutia_first_block_block",
 *   admin_label = @block("My first block"),
 * )
 */
class FirstBlock extends BlockBase {
  /**
   * {@block}
   */
  public function build() {
    $config = $this->getConfiguration();
  
    if (!empty($config['liutia_first_block_settings'])) {
      $form['liutia_first_block_settings'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#description' => $this->t('Who do you want to say hello to?'),
        '#default_value' => !empty($config['liutia_first_block_settings']) ? $config['liutia_first_block_settings'] : '',
      ];
    
      return $form;    }
    else {
      $text = $this->t('Hello World in block!');
    }
  
    return [
      '#markup' => $text,
    ];
  }
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
  
    $form['liutia_first_block_settings'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => !empty($config['liutia_first_block_settings']) ? $config['liutia_first_block_settings'] : '',
    ];
  
    return $form;
  }
  
  /**
   * {@block}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }
  
  /**
   * {@block}
   */

  
  /**
   * {@block}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['liutia_first_block_settings'] = $form_state->getValue('liutia_first_block_settings');
  }
}