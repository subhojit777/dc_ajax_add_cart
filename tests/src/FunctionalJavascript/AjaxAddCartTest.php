<?php

namespace Drupal\Tests\dc_ajax_add_cart\FunctionalJavascript;

use Drupal\Tests\commerce\FunctionalJavascript\JavascriptTestTrait;
use Drupal\Tests\commerce_cart\Functional\CartBrowserTestBase;
use Drupal\commerce_order\Entity\Order;

/**
 * Ajax add cart tests.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AjaxAddCartTest extends CartBrowserTestBase {

  use JavascriptTestTrait;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'commerce_product',
    'commerce_cart',
    'dc_ajax_add_cart',
    'dc_ajax_add_cart_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Change commerce_product variation view display to dc_ajax_add_cart.
    \Drupal::entityTypeManager()
      ->getStorage('entity_view_display')
      ->load('commerce_product.default.default')
      ->setComponent('variations', [
        'type' => 'dc_ajax_add_cart',
        'settings' => [
          'default_quantity' => '1',
          'combine' => TRUE,
          'show_quantity' => FALSE,
        ],
        'weight' => 0,
        'label' => 'hidden',
        'region' => 'content',
      ])
      ->save();
  }

  /**
   * Tests whether product is added to cart.
   */
  public function testAjaxAddCart() {
    $this->drupalGet("product/{$this->variation->getProduct()->id()}");
    $ajax_add_cart_button = $this->getSession()->getPage()->findButton('Add to cart');

    $ajax_add_cart_button->click();
    $this->waitForAjaxToFinish();

    // Confirm that the initial add to cart submit works.
    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();
    $this->assertOrderItemInOrder($this->variation, $order_items[0]);

    $ajax_add_cart_button->click();
    $this->waitForAjaxToFinish();

    // Confirm that the second add to cart submit increments the quantity
    // of the first order item.
    \Drupal::entityTypeManager()->getStorage('commerce_order')->resetCache();
    \Drupal::entityTypeManager()->getStorage('commerce_order_item')->resetCache();
    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();
    $this->assertNotEmpty(count($order_items) == 1, 'No additional order items were created');
    $this->assertOrderItemInOrder($this->variation, $order_items[0], 2);
  }

}
