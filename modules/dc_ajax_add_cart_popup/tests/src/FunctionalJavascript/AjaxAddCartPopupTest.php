<?php

namespace Drupal\Tests\dc_ajax_add_cart_popup\FunctionalJavascript;

use Drupal\commerce_order\Entity\Order;
use Drupal\Tests\dc_ajax_add_cart\Functional\AjaxAddCartTestBase;

/**
 * Ajax add cart popup tests.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AjaxAddCartPopupTest extends AjaxAddCartTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'dc_ajax_add_cart_popup',
  ];

  /**
   * Tests whether the popup appears after product added to cart.
   */
  public function testAjaxPopup() {
    $this->drupalGet("product/{$this->variation->getProduct()->id()}");
    $ajax_add_cart_button = $this->getSession()->getPage()->findButton('Add to cart');

    $ajax_add_cart_button->click();
    $this->waitForAjaxToFinish();

    // Confirm that the initial add to cart submit works.
    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();
    $this->assertOrderItemInOrder($this->variation, $order_items[0]);

    // Confirm that the popup has appeared.
    $this->assertSession()->pageTextContains("The item has been added to your cart.", 'Popup not found.');
  }

  /**
   * Tests that the popup is indeed Ajaxified.
   */
  public function testPopupIsAjaxified() {
    $this->drupalGet("product/{$this->variation->getProduct()->id()}");
    $ajax_add_cart_button = $this->getSession()->getPage()->findButton('Add to cart');

    $ajax_add_cart_button->click();

    // Confirm that the popup has NOT appeared. It should not have appeared yet,
    // since we didn't wait for AJAX to finish.
    $this->assertSession()->pageTextNotContains("The item has been added to your cart.", 'Popup was found before AJAX finished.');
  }

}
