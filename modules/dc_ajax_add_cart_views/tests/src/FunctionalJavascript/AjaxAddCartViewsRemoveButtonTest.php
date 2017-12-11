<?php

namespace Drupal\Tests\dc_ajax_add_cart_views\FunctionalJavascript;

use Drupal\Tests\dc_ajax_add_cart_views\Functional\AjaxAddCartViewsTestBase;

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

    $this->drupalGet("cart-ajax/{$this->cart->id()}");
    $this->assertCartAjaxPage();

    $variation_row_element = $this->getRowCartAjaxByVariation($this->getRandomVariation());
    $this->assertVariationRowCartAjax($variation_row_element);

    $variation_row_element->findButton('Remove')
      ->click();
    $this->waitForAjaxToFinish();
  }

}
