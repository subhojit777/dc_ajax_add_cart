<?php

namespace Drupal\dc_ajax_add_cart;

use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\block\Entity\Block;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Provides methods that would help in refreshing certain page elements.
 */
class RefreshPageElementsHelper {

  /**
   * Refreshes status messages.
   *
   * @param \Drupal\Core\Ajax\AjaxResponse $response
   *   The AjaxResponse where the update commands are going to be added.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Updated response.
   *
   * @TODO Get the following approach reviewed by someone.
   */
  public static function updateStatusMessages(AjaxResponse $response) {
    /** @var \Drupal\block\BlockInterface $block */
    $block = self::getStatusMessagesBlock();
    if ($block) {
      $elements = [
        '#type' => 'status_messages',
      ];

      $response->addCommand(new RemoveCommand('.messages__wrapper'));
      $response->addCommand(new AppendCommand(".region-{$block->getRegion()}", \Drupal::service('renderer')->renderRoot($elements)));
    }

    return $response;
  }

  /**
   * Returns the region where messages block is placed in the current theme.
   *
   * @return \Drupal\block\BlockInterface|null
   *   Returns status_messages block entity, NULL if not present.
   */
  protected static function getStatusMessagesBlock() {
    /** @var \Drupal\Core\Theme\ThemeManagerInterface $theme_manager */
    $theme_manager = \Drupal::service('theme.manager');
    $active_theme = $theme_manager->getActiveTheme()->getName();

    /** @var \Drupal\block\BlockInterface $block */
    $block = Block::load("{$active_theme}_messages");

    return $block;
  }

}
