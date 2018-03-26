<?php

namespace Drupal\Tests\dc_ajax_add_cart_popup\FunctionalJavascript;

use Drupal\commerce_order\Entity\Order;
use Drupal\Tests\commerce_cart\Functional\CartBrowserTestBase;

/**
 * Add cart popup ajax response tests.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AddCartPopupAjaxResponseTest extends CartBrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'commerce_product',
    'commerce_cart',
    'dc_ajax_add_cart_popup',
  ];

  /**
   * Tests whether the popup appears only when product added to cart via ajax.
   */
  public function testPopupOnAjaxResponse() {
    $this->drupalGet("product/{$this->variation->getProduct()->id()}");
    $add_cart_button = $this->getSession()->getPage()->findButton('Add to cart');

    $add_cart_button->click();

    // Confirm that the initial add to cart submit works.
    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();
    $this->assertOrderItemInOrder($this->variation, $order_items[0]);

    $this->assertSession()->pageTextNotContains("The item has been added to your cart.", 'Popup was found before AJAX finished.');
  }

}
