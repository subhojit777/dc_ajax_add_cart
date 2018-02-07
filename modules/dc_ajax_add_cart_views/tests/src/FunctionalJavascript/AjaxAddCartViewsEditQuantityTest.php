<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\FunctionalJavascript;

use Drupal\Tests\dc_ajax_add_cart_views\Functional\AjaxAddCartViewsTestBase;
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

    $cart_variation = array_pop($this->variations);
    $this->cartManager->addEntity($this->cart, $cart_variation);

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
  }

  /**
   * Tests whether the update cart button is indeed ajaxified.
   */
  public function testAjaxUpdateCartButton() {
    $this->drupalLogin($this->account);

    $cart_variation = array_pop($this->variations);
    $this->cartManager->addEntity($this->cart, $cart_variation);

    $this->drupalGet("cart-update-ajax/{$this->cart->id()}");
    $this->assertCartAjaxPage();

    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $variation_position = $this->getVariationRowPositionCartAjax($cart_variation);
    $this->assertVariationRowPosition($variation_position);

    $variation_row_element->fillField("dc_ajax_add_cart_views_edit_quantity[{$variation_position}]", '2');

    $this->getSession()->getPage()->findButton('Update cart')
      ->click();

    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();

    // Check whether the product quantity is still the same.
    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $this->assertVariationInOrder($cart_variation, $order_items);
  }

  /**
   * Tests whether order total is correct on ajax quantity update.
   */
  public function testOrderTotal() {
    $this->drupalLogin($this->account);

    $cart_variation = array_pop($this->variations);
    $this->cartManager->addEntity($this->cart, $cart_variation);

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

    $price = $this->getSession()->getPage()->find('css', '.order-total-line__total .order-total-line-value')->getText();
    $price = (float) preg_replace('/[^0-9\.]/', '', $price);
    $actual_price = (float) $this->cart->getTotalPrice()->getNumber();
    $this->assertEquals($price, $actual_price, 'Prices are not equal.');
  }

}
