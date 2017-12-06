<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\Functional;

use Drupal\Tests\dc_ajax_add_cart\Functional\AjaxAddCartTestBase;

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
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

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

}
