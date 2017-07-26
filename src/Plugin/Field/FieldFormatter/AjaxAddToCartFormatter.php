<?php

namespace Drupal\dc_ajax_add_cart\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\commerce_product\Plugin\Field\FieldFormatter\AddToCartFormatter;

/**
 * Plugin implementation of the 'dc_ajax_add_cart' formatter.
 *
 * @FieldFormatter(
 *   id = "dc_ajax_add_cart",
 *   label = @Translation("Ajax add to cart form"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class AjaxAddToCartFormatter extends AddToCartFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $elements[0]['dc_ajax_add_cart_form'] = [
      '#lazy_builder' => [
        'dc_ajax_add_cart.lazy_builders:ajaxAddToCartForm', [
          $items->getEntity()->id(),
          $this->viewMode,
          $this->getSetting('combine'),
        ],
      ],
      '#create_placeholder' => TRUE,
    ];
    return $elements;
  }

}
