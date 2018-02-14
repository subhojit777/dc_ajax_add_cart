<?php

namespace Drupal\Tests\dc_ajax_add_cart\FunctionalJavascript;

use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_product\Entity\ProductAttribute;
use Drupal\Tests\dc_ajax_add_cart\Functional\AjaxAddCartTestBase;
use Drupal\commerce_product\Entity\ProductType;
use Drupal\commerce_product\Entity\ProductVariationType;

/**
 * Ajax add cart tests with multiple variations.
 *
 * See https://www.drupal.org/project/dc_ajax_add_cart/issues/2941584
 *
 * @ingroup dc_ajax_add_cart
 *
 * @group dc_ajax_add_cart
 */
class AjaxAddCartMultipleVariationTest extends AjaxAddCartTestBase {

  /**
   * Product attributes (size).
   *
   * @var \Drupal\commerce_product\Entity\ProductAttributeValueInterface[]
   */
  protected $sizeAttributes = [];

  /**
   * Test product.
   *
   * @var \Drupal\commerce_product\Entity\ProductInterface
   */
  protected $product;

  /**
   * An array of variations.
   *
   * @var array
   */
  protected $variations;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Copied from MultipleCartMultipleVariationTypesTest::setUp().
    $this->variation->getProduct()->setUnpublished();
    $this->variation->getProduct()->save();

    $this->createProductAndVariationType('sizes', 'Sizes');

    $size_attribute = ProductAttribute::create([
      'id' => 'size',
      'label' => 'Size',
    ]);
    $size_attribute->save();
    $this->attributeFieldManager->createField($size_attribute, 'sizes');
    $options = [
      'small' => 'Small',
      'medium' => 'Medium',
      'large' => 'Large',
      'xl' => 'X-Large',
      'xxl' => 'XX-Large',
    ];
    foreach ($options as $key => $value) {
      $this->sizeAttributes[$key] = $this->createAttributeValue($size_attribute->id(), $value);
    }

    $product_data = [
      'type' => 'sizes',
      'variations' => [
        ['attribute_size' => $this->sizeAttributes['small']->id()],
        ['attribute_size' => $this->sizeAttributes['medium']->id()],
        ['attribute_size' => $this->sizeAttributes['large']->id()],
        ['attribute_size' => $this->sizeAttributes['xl']->id()],
        ['attribute_size' => $this->sizeAttributes['xxl']->id()],
      ],
    ];

    /** @var \Drupal\commerce_product\Entity\ProductInterface $product */
    $this->product = $this->createEntity('commerce_product', [
      'type' => $product_data['type'],
      'title' => $this->randomString(),
      'stores' => [$this->store],
    ]);

    foreach ($product_data['variations'] as $variation_data) {
      $variation_data += [
        'type' => $product_data['type'],
        'sku' => 'sku-' . $this->randomMachineName(),
        'price' => [
          'number' => '10',
          'currency_code' => 'USD',
        ],
      ];

      /** @var \Drupal\commerce_product\Entity\ProductVariationInterface $variation */
      $variation = $this->createEntity('commerce_product_variation', $variation_data);
      $this->product->addVariation($variation);
    }

    $this->product->save();

    // Change commerce_product variation view display to dc_ajax_add_cart.
    \Drupal::entityTypeManager()
      ->getStorage('entity_view_display')
      ->load('commerce_product.sizes.default')
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
   * Tests multiple variation ajax add to cart.
   */
  public function testMultipleVariation() {
    $this->drupalGet("product/{$this->product->id()}");
    $element = $this->getSession()->getPage()->find('xpath', "//select[@name='purchased_entity[0][attributes][attribute_size]']");

    $this->getSession()->getPage()->findButton('Add to cart')->click();
    $this->waitForAjaxToFinish();

    $element->selectOption('Medium');
    $this->waitForAjaxToFinish();

    $this->getSession()->getPage()->findButton('Add to cart')->click();
    $this->waitForAjaxToFinish();

    $element->selectOption('Large');
    $this->waitForAjaxToFinish();

    $this->getSession()->getPage()->findButton('Add to cart')->click();
    $this->waitForAjaxToFinish();

    $element->selectOption('X-Large');
    $this->waitForAjaxToFinish();

    $this->getSession()->getPage()->findButton('Add to cart')->click();
    $this->waitForAjaxToFinish();

    $element->selectOption('XX-Large');
    $this->waitForAjaxToFinish();

    $this->getSession()->getPage()->findButton('Add to cart')->click();
    $this->waitForAjaxToFinish();

    $this->cart = Order::load($this->cart->id());
    $order_items = $this->cart->getItems();
    $this->assertCount(5, $order_items, 'Order items missing in the cart.');
    $this->assertOrderItemInOrder($order_items[0]->getPurchasedEntity(), $order_items[0]);
    $this->assertOrderItemInOrder($order_items[1]->getPurchasedEntity(), $order_items[1]);
    $this->assertOrderItemInOrder($order_items[2]->getPurchasedEntity(), $order_items[2]);
    $this->assertOrderItemInOrder($order_items[3]->getPurchasedEntity(), $order_items[3]);
    $this->assertOrderItemInOrder($order_items[4]->getPurchasedEntity(), $order_items[4]);
  }

  /**
   * Creates a product and product variation type.
   *
   * Copied from MultipleCartMultipleVariationTypesTest.
   *
   * @param string $id
   *   The ID.
   * @param string $label
   *   The label.
   */
  protected function createProductAndVariationType($id, $label) {
    $variation_type = ProductVariationType::create([
      'id' => $id,
      'label' => $label,
      'orderItemType' => 'default',
      'generateTitle' => TRUE,
    ]);
    $variation_type->save();
    $product_type = ProductType::create([
      'id' => $id,
      'label' => $label,
      'variationType' => $variation_type->id(),
    ]);
    $product_type->save();
    commerce_product_add_stores_field($product_type);
    commerce_product_add_variations_field($product_type);
  }

}
