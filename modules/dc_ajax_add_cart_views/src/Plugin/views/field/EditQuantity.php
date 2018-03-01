<?php

namespace Drupal\dc_ajax_add_cart_views\Plugin\views\field;

use Drupal\commerce_cart\Plugin\views\field\EditQuantity as BaseEditQuantity;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form element for editing the order item quantity.
 *
 * @ViewsField("dc_ajax_add_cart_views_item_edit_quantity")
 */
class EditQuantity extends BaseEditQuantity {

  /**
   * {@inheritdoc}
   */
  public function viewsForm(array &$form, FormStateInterface $form_state) {
    parent::viewsForm($form, $form_state);

    $wrapper_id = $this->view->storage->id() . '-cart-ajax-wrapper';

    $form['#attached']['library'][] = 'core/jquery.form';
    $form['#attached']['library'][] = 'core/drupal.ajax';

    $form['#prefix'] = "<div id='{$wrapper_id}'>";
    $form['#suffix'] = '</div>';

    $form['actions']['submit']['#attributes']['class'][] = 'use-ajax-submit';
    $form['actions']['submit']['#ajax'] = [
      'wrapper' => $wrapper_id,
    ];
  }

}
