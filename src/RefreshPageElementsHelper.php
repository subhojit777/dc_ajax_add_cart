<?php

namespace Drupal\dc_ajax_add_cart;

use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;
use Drupal\block\Entity\Block;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Theme\ThemeManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Block\BlockManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Render\RendererInterface;

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
   * Theme manager.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  protected $themeManager;

  /**
   * Entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Block manager.
   *
   * @var \Drupal\Core\Block\BlockManagerInterface
   */
  protected $blockManager;

  /**
   * Renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a new RefreshPageElementsHelper object.
   *
   * @param \Drupal\Core\Theme\ThemeManagerInterface $theme_manager
   *   The theme manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Block\BlockManagerInterface $block_manager
   *   The block manager.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(ThemeManagerInterface $theme_manager, EntityTypeManagerInterface $entity_type_manager, BlockManagerInterface $block_manager, RendererInterface $renderer) {
    $this->themeManager = $theme_manager;
    $this->entityTypeManager = $entity_type_manager;
    $this->blockManager = $block_manager;
    $this->renderer = $renderer;
    $this->response = new AjaxResponse();
  }

  /**
   * Creates instance of RefreshPageElementsHelper class.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('theme.manager'),
      $container->get('entity.query'),
      $container->get('plugin.manager.block'),
      $container->get('renderer')
    );
  }

  /**
   * Returns status messages block id for the active theme.
   *
   * @return string|null
   *   The block id, NULL if the block is not placed for the active theme.
   */
  public function getStatusMessagesBlockId() {
    $active_theme = $this->themeManager->getActiveTheme()->getName();

    $query = $this->entityTypeManager->getStorage('block')->getQuery();
    $block_ids = $query->condition('plugin', 'system_messages_block')
      ->condition('theme', $active_theme)
      ->execute();

    return array_shift($block_ids);
  }

  /**
   * Refreshes status messages.
   *
   * @return $this
   */
  public function updateStatusMessages() {
    $block_id = $this->getStatusMessagesBlockId();

    if ($block_id) {
      /** @var \Drupal\block\BlockInterface $block */
      $block = Block::load($block_id);

      $elements = [
        '#type' => 'status_messages',
      ];

      $this->response->addCommand(new RemoveCommand('.messages__wrapper'));
      $this->response->addCommand(new AppendCommand(".region-{$block->getRegion()}", $this->renderer->renderRoot($elements)));
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
    /** @var \Drupal\Core\Block\BlockPluginInterface $block */
    $block = $this->blockManager->createInstance('commerce_cart', []);

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
   * Updates the form build id.
   *
   * @param array $form
   *   Drupal form.
   *
   * @return $this
   */
  public function updateFormBuildId(array $form) {
    // If the form build ID has changed, issue an Ajax command to update it.
    if (isset($form['#build_id_old']) && $form['#build_id_old'] !== $form['#build_id']) {
      $this->response->addCommand(new UpdateBuildIdCommand($form['#build_id_old'], $form['#build_id']));
    }

    return $this;
  }

  /**
   * Updates page elements.
   *
   * @param array $form
   *   Drupal form.
   *
   * @return $this
   */
  public function updatePageElements(array $form) {
    return $this->updateFormBuildId($form)
      ->updateStatusMessages()
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
