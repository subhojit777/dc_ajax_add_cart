<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\FunctionalJavascript;

use Drupal\Tests\dc_ajax_add_cart_views\Functional\AjaxAddCartViewsTestBase;
use Drupal\commerce_product\Entity\ProductVariation;

/**
 * Commerce Ajax Add to Cart Views Remove Button tests.
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AjaxAddCartViewsRemoveButtonTest extends AjaxAddCartViewsTestBase {

  /**
   * Tests remove button views field.
   */
  public function testRemoveButton() {
    foreach ($this->variations as $variation) {
      $this->cartManager->addEntity($this->cart, $variation);
    }

    $cart_variation = $this->getRandomVariation();
    $variation_ids = array_map(function ($variation) {
      return $variation->id();
    }, $this->variations);

    $other_variation_id = array_diff($variation_ids, [$cart_variation->id()]);
    $other_variation = ProductVariation::load(array_pop($other_variation_id));

    $this->drupalGet("cart-ajax/{$this->cart->id()}");
    $this->assertCartAjaxPage();

    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertVariationRowCartAjax($variation_row_element);

    $variation_row_element->findButton('Remove')
      ->click();
    $this->waitForAjaxToFinish();

    // Check if the product is indeed gone from the UI.
    $variation_row_element = $this->getRowCartAjaxByVariation($cart_variation);
    $this->assertNotVariationRowCartAjax($variation_row_element);

    // Check if the other product is still present in the UI.
    $variation_row_element = $this->getRowCartAjaxByVariation($other_variation);
    $this->assertVariationRowCartAjax($variation_row_element);
    $element = $variation_row_element->find('css', "td.views-field-edit-quantity input[value='1']");
    $this->assertNotNull($element, t('@product with incorrect quantity found on ajax cart.', [
      '@product' => $other_variation->getProduct()->getTitle(),
    ]));
  }

}
