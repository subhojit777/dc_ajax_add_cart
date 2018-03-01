<?php

namespace Drupal\dc_ajax_add_cart_views\Plugin\views\field;

use Drupal\commerce_cart\Plugin\views\field\RemoveButton as BaseRemoveButton;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form element for removing the order item via ajax.
 *
 * @ViewsField("dc_ajax_add_cart_views_item_remove_button")
 */
class RemoveButton extends BaseRemoveButton {

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

    foreach ($this->view->result as $row_index => $row) {
      $form[$this->options['id']][$row_index] = [
        '#type' => 'submit',
        '#value' => t('Remove'),
        '#name' => 'delete-order-item-' . $row_index,
        '#remove_order_item' => TRUE,
        '#row_index' => $row_index,
        '#attributes' => [
          'class' => [
            'delete-order-item',
            'use-ajax-submit',
          ],
        ],
        '#ajax' => [
          'wrapper' => $wrapper_id,
        ],
      ];
    }
  }

}
