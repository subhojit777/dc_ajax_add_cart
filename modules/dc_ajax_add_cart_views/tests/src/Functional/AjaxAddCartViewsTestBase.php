<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\Functional;

use Drupal\Tests\dc_ajax_add_cart\Functional\AjaxAddCartTestBase;
use Drupal\commerce_product\Entity\ProductVariationInterface;

/**
 * Base class for ajax add cart views tests.
 */
abstract class AjaxAddCartViewsTestBase extends AjaxAddCartTestBase {

  /**
   * An array of variations.
   *
   * @var array
   */
  protected $variations;

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'dc_ajax_add_cart_views',
    'dc_ajax_add_cart_views_test',
  ];

  /**
   * User account.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->account = $this->drupalCreateUser([
      'access cart',
    ]);

    // Copied from CartTest::setUp().
    $this->variations = [$this->variation];
    // Create an additional variation in order to test updating multiple
    // quantities in cart.
    $variation = $this->createEntity('commerce_product_variation', [
      'type' => 'default',
      'sku' => $this->randomMachineName(),
      'price' => [
        'number' => 350,
        'currency_code' => 'USD',
      ],
    ]);
    // We need a product too otherwise tests complain about the missing
    // backreference.
    $this->createEntity('commerce_product', [
      'type' => 'default',
      'title' => $this->randomMachineName(),
      'stores' => [$this->store],
      'variations' => [$variation],
    ]);
    $this->variations[] = $variation;
  }

  /**
   * Asserts ajaxified cart page.
   */
  protected function assertCartAjaxPage() {
    $this->assertResponse(200, 'Ajax cart page not found.');
  }

  /**
   * Asserts presence of the variation row on cart page.
   *
   * @param \Behat\Mink\Element\NodeElement|null $element
   *   The table row element to check.
   */
  protected function assertVariationRowCartAjax($element) {
    $this->assertNotNull($element, 'Variation not found on ajax cart.');
  }

  /**
   * Asserts absence of the variation row on cart page.
   *
   * @param \Behat\Mink\Element\NodeElement|null $element
   *   The table row element to check.
   */
  protected function assertNotVariationRowCartAjax($element) {
    $this->assertNull($element, 'Variation found on ajax cart.');
  }

  /**
   * Returns the table row element where the variation is present.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The variation whose row is going to be returned.
   *
   * @return \Behat\Mink\Element\NodeElement|null
   *   The table row element, if found, otherwise NULL.
   */
  protected function getRowCartAjaxByVariation(ProductVariationInterface $variation) {
    return $this->getSession()->getPage()->find('css', ".view-dc-ajax-add-cart-views-test-view table tr.variation-{$variation->id()}");
  }

  /**
   * Returns a random variation.
   *
   * This variation is going to be added to cart.
   *
   * @return \Drupal\commerce_product\Entity\ProductVariationInterface
   *   The product variation.
   */
  protected function getRandomVariation() {
    return $this->variations[mt_rand(0, (count($this->variations) - 1))];
  }

  /**
   * Asserts whether the variation is present in order items.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The purchased product variation.
   * @param \Drupal\commerce_order\Entity\OrderItemInterface[] $order_items
   *   The order items.
   * @param int $quantity
   *   (Optional) The quantity for an additional check.
   */
  protected function assertVariationInOrder(ProductVariationInterface $variation, array $order_items, $quantity = 1) {
    $is_present = FALSE;

    foreach ($order_items as $item) {
      if ($item->getPurchasedEntity()->id() === $variation->id() &&
        $item->getQuantity() == $quantity) {
        $is_present = TRUE;
      }
    }

    $this->assertTrue($is_present, 'Variation not present in cart.');
  }

  /**
   * Asserts whether the variation is not present in order items.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The purchased product variation.
   * @param \Drupal\commerce_order\Entity\OrderItemInterface[] $order_items
   *   The order items.
   */
  protected function assertNotVariationInOrder(ProductVariationInterface $variation, array $order_items) {
    $is_present = TRUE;

    foreach ($order_items as $item) {
      if ($item->getPurchasedEntity()->id() !== $variation->id()) {
        $is_present = FALSE;
      }
      else {
        $is_present = TRUE;
      }
    }

    $this->assertFalse($is_present, 'Variation present in cart.');
  }

  /**
   * Returns the row position of the variation in cart.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $variation
   *   The variation whose row position is going to be returned.
   *
   * @return int|bool
   *   The row position if found, otherwise FALSE.
   */
  protected function getVariationRowPositionCartAjax(ProductVariationInterface $variation) {
    $row_elements = $this->getSession()->getPage()->findAll('css', '.view-dc-ajax-add-cart-views-test-view table tbody tr');

    foreach ($row_elements as $position => $e) {
      if ($e->hasClass("variation-{$variation->id()}")) {
        return $position;
      }
    }

    return FALSE;
  }

  /**
   * Asserts the variation row position in cart.
   *
   * @param int|bool $position
   *   The row position.
   */
  protected function assertVariationRowPosition($position) {
    $this->assertInternalType('int', $position, 'Variation not present in cart.');
  }

}
