<?php

namespace Drupal\dc_ajax_add_cart_views\Plugin\views\field;

use Drupal\commerce_cart\Plugin\views\field\RemoveButton as BaseRemoveButton;

/**
 * Defines a form element for removing the order item via ajax.
 *
 * @ViewsField("dc_ajax_add_cart_views_item_remove_button")
 */
class RemoveButton extends BaseRemoveButton {
}
