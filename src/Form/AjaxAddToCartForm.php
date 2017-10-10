<?php

namespace Drupal\dc_ajax_add_cart\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_cart\Form\AddToCartForm;
use Drupal\Component\Utility\Html;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\UpdateBuildIdCommand;
use Drupal\block\Entity\Block;

/**
 * Provides the order item ajax add to cart form.
 */
class AjaxAddToCartForm extends AddToCartForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    // @TODO Remove this once https://www.drupal.org/node/2897120 gets into
    // core.
    $form['#attached']['library'][] = 'core/jquery.form';
    $form['#attached']['library'][] = 'core/drupal.ajax';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $wrapper_id = Html::getUniqueId($this->getFormId() . '-ajax-add-cart-wrapper');

    $actions['submit'] = [
      '#prefix' => '<div id="' . $wrapper_id . '">',
      '#suffix' => '</div>',
      '#type' => 'submit',
      '#value' => $this->t('Add to cart'),
      '#submit' => ['::submitForm'],
      '#attributes' => [
        'class' => ['use-ajax-submit'],
      ],
      '#ajax' => [
        'callback' => [get_class($this), 'refreshAddToCartForm'],
        'wrapper' => $wrapper_id,
      ],
    ];

    return $actions;
  }

  /**
   * Refreshes the add to cart form.
   *
   * Fixes https://www.drupal.org/node/2905814
   */
  public static function refreshAddToCartForm(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    // If the form build ID has changed, issue an Ajax command to update it.
    if (isset($form['#build_id_old']) && $form['#build_id_old'] !== $form['#build_id']) {
      $response->addCommand(new UpdateBuildIdCommand($form['#build_id_old'], $form['#build_id']));
    }

    /*
     * Update status messages.
     *
     * @TODO Get the following approach reviewed by someone.
     */
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
   *   Returns status_messages block entity, or NULL if not present.
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
