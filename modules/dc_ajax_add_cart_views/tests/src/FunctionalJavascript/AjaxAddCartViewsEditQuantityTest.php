<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\FunctionalJavascript;

use Drupal\Tests\dc_ajax_add_cart_views\Functional\AjaxAddCartViewsTestBase;
use Drupal\commerce_product\Entity\ProductVariation;
use Drupal\commerce_order\Entity\Order;

/**
 * Commerce Ajax Add to Cart Views Edit Quantity tests.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AjaxAddCartViewsEditQuantityTest extends AjaxAddCartViewsTestBase {

  /**
   * Tests edit quantity views field.
   */
  public function testUpdateCartButton() {
    $this->drupalLogin($this->account);

    foreach ($this->variations as $variation) {
      $this->cartManager->addEntity($this->cart, $variation);
    }

    $cart_variation = $this->getRandomVariation();
    $variation_ids = array_map(function ($variation) {
      return $variation->id();
    }, $this->variations);

    $other_variation_id = array_diff($variation_ids, [$cart_variation->id()]);
    $other_variation = ProductVariation::load(array_pop($other_variation_id));

    $this->drupalGet("cart-update-ajax/{$this->cart->id()}");
    $this->assertCartAjaxPage();

    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $variation_position = $this->getVariationRowPositionCartAjax($cart_variation);
    $this->assertVariationRowPosition($variation_position);

    $variation_row_element->fillField("dc_ajax_add_cart_views_edit_quantity[{$variation_position}]", '2');

    $this->getSession()->getPage()->findButton('Update cart')
      ->click();
    $this->waitForAjaxToFinish();

    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();

    // Check if the product quantity has been updated.
    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $this->assertVariationInOrder($cart_variation, $order_items, 2);

    // Check if the other product quantity is still the same.
    $variation_row_element = $this->getRowCartAjaxByVariation($other_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $this->assertVariationInOrder($other_variation, $order_items);
  }

}