<?php

namespace Drupal\dc_ajax_add_cart;

use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\block\Entity\Block;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Provides methods that would help in refreshing certain page elements.
 */
class RefreshPageElementsHelper {

  /**
   * Ajax response.
   *
   * @var \Drupal\Core\Ajax\AjaxResponse
   */
  protected $response;

  /**
   * Constructs a new RefreshPageElementsHelper object.
   *
   * @param \Drupal\Core\Ajax\AjaxResponse $response
   *   The ajax response.
   */
  public function __construct(AjaxResponse $response) {
    $this->response = $response;
  }

  /**
   * Returns the region where messages block is placed in the current theme.
   *
   * @return \Drupal\block\BlockInterface|null
   *   Returns status_messages block entity, NULL if not present.
   */
  protected function getStatusMessagesBlock() {
    /** @var \Drupal\Core\Theme\ThemeManagerInterface $theme_manager */
    $theme_manager = \Drupal::service('theme.manager');
    $active_theme = $theme_manager->getActiveTheme()->getName();

    /** @var \Drupal\block\BlockInterface $block */
    $block = Block::load("{$active_theme}_messages");

    return $block;
  }

  /**
   * Refreshes status messages.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Updated response.
   *
   * @TODO Get the following approach reviewed by someone.
   */
  public function updateStatusMessages() {
    /** @var \Drupal\block\BlockInterface $block */
    $block = $this->getStatusMessagesBlock();
    if ($block) {
      $elements = [
        '#type' => 'status_messages',
      ];

      $this->response->addCommand(new RemoveCommand('.messages__wrapper'));
      $this->response->addCommand(new AppendCommand(".region-{$block->getRegion()}", \Drupal::service('renderer')->renderRoot($elements)));
    }

    return $this;
  }

  /**
   * Returns cart block.
   *
   * @return \Drupal\Core\Block\BlockPluginInterface
   *   The cart block.
   */
  protected function getCartBlock() {
    /** @var \Drupal\Core\Block\BlockManagerInterface $block_manager */
    $block_manager = \Drupal::service('plugin.manager.block');
    /** @var \Drupal\Core\Block\BlockPluginInterface $block */
    $block = $block_manager->createInstance('commerce_cart', []);

    return $block;
  }

  /**
   * Updates content inside cart block.
   *
   * @return $this
   */
  public function updateCart() {
    /** @var \Drupal\Core\Block\BlockPluginInterface $block */
    $block = $this->getCartBlock();

    $this->response->addCommand(new ReplaceCommand('.cart--cart-block', $block->build()));

    return $this;
  }

  /**
   * Updates page elements.
   *
   * @return $this
   */
  public function updatePageElements() {
    return $this->updateStatusMessages()
      ->updateCart();
  }

  /**
   * Returns the ajax response.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   The ajax response.
   */
  public function getResponse() {
    return $this->response;
  }

}
