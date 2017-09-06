<?php

namespace Drupal\dc_ajax_add_cart\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\commerce_cart\Form\AddToCartForm;
use Drupal\Component\Utility\Html;

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
    return $form['actions']['submit'];
  }

}
