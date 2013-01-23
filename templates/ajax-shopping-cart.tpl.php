<?php

/**
 * @file
 * Ajax shopping cart block template file.
 */

/**
 * Available variables:
 * - $order: Order object of the current user.
 * - $line_items: Line items wrapper.
 * - $quantity: Number of items in the cart.
 * - $total: Array containing the total amount and the default currency you are
 *   in the site.
 *
 * Other variables:
 * - $line_item_list: Array containing all line item objects.
 * - $products: Array containing all product objects that are stored in the
 *   cart.
 * - $product_prices: Array containing the prices of products in cart. The price
 *   also has currency code or symbol attached to it. Currency code or symbol
 *   depends on the AJAX Add to Cart settings.
 * - $product_price_total: Total amount including taxes. The total has currency
 *   code or symbol attached to it. Currency code or symbol depends on the AJAX
 *   Add to Cart settings.
 * - $checkout_url: The checkout url depends on AJAX Add to Cart settings.
 * - $shipping: If you have included shipping prices then this variable will be
 *   available. This is an array containing the details of the shipping you have
 *   included in order. If you have not included shipping in your order then
 *   this variable will not be available.
 * - $show_labels: Check whether to display labels in cart.
 * - $remove_cart: Check whether to display link or image in for the option
 *   remove product from cart.
 * - $empty_cart_message: Message to display if the cart is empty.
 *
 * If you want to make changes in the structure Shopping Cart, copy this file to
 * your theme's templates directory.
 *
 * DO NOT change this file.
 */
?>

<?php $content = ''; ?>
<?php if($order && $quantity != 0): ?>
  <!-- Order object present and cart is not empty. -->
  <div id="ajax-shopping-cart-wrapper" class="ajax-shopping-cart-wrapper">
    <div class="ajax-shopping-cart-table">
      <?php if($configuration['show_labels'] == 'label'): ?>
        <div class="ajax-shopping-cart-labels">
          <span class="quantity-label">
            <?php echo t('Quantity'); ?>
          </span>
          <span class="item-label">
            <?php echo t('Items'); ?>
          </span>
          <span class="price-label">
            <?php echo t('Price'); ?>
          </span>
        </div>
      <?php endif; ?>
      <div class="ajax-shopping-cart-details">
        <!-- Start foreach loop. -->
        <?php foreach ($line_item_list as $line_item) :
          if (property_exists($line_item, 'commerce_product')) :
            $product = commerce_product_load($line_item->commerce_product[LANGUAGE_NONE][0]['product_id']);
            $content .= '<div class="product-line-item product-line-item-id-' . $line_item->line_item_id . '">
                          <span class="quantity">' . intval($line_item->quantity) . '</span>
                          <span class="name">' . $product->title . '</span>
                          <span class="price">' . $product_prices[$product->product_id] . '</span>
                          <span class="remove-from-cart">' . l($configuration['remove_cart'] == 'link' ? t('Remove form cart') : '<img src="' . base_path() . drupal_get_path('module', 'dc_ajax_add_cart') . '/images/remove-from-cart.png' . '" />', 'remove-product/nojs/' . $line_item->line_item_id, array('attributes' => array('class' => array('use-ajax')), 'html' => TRUE)) . '</span>
                        </div>';
          elseif (property_exists($line_item, 'commerce_shipping_service') && isset($shipping)) :
            $content .= '<div class="ajax-shopping-cart-shipping">' . $shipping['service'] . ' ' . $shipping['price'] . '</div>';
          endif;
        endforeach;

        if ($configuration['display_tax'] == 'display') :
          $wrapper = '<div class="ajax-shopping-cart-tax-wrapper">';
          $tax_rates = commerce_tax_rates();
          $tax_rate_content = '';

          foreach ($tax_rates as $tax_rate) :
            $tax_rate_content .= '<div class="tax-' . $tax_rate['name'] . '">
                                    <span>' . $tax_rate['display_title'] . '</span>
                                    <span>' . $tax_rate['rate'] * 100 . '%</span>
                                  </div>';
          endforeach;

          $content .= $wrapper . $tax_rate_content . '</div>';
        endif; ?>
        <!-- End of foreach loop. -->
        <?php echo $content; ?>
      </div>
    </div>
    <span class="ajax-shopping-cart-total">
      <?php echo t('Total:') . ' ' . $product_price_total; ?>
    </span>
    <span class="ajax-shopping-cart-checkout">
      <?php echo $checkout_url; ?>
    </span>
  </div>
<?php elseif($quantity == 0 || !$order): ?>
  <!-- Cart is empty or order object is null. -->
  <div id="ajax-shopping-cart-wrapper" class="ajax-shopping-cart-wrapper">
    <div class="empty-shopping-cart">
      <?php echo $configuration['empty_cart_message']; ?>
    </div>
    <div class="ajax-shopping-cart-total"></div>
    <div class="ajax-shopping-cart-checkout"></div>
  </div>
<?php endif; ?>
