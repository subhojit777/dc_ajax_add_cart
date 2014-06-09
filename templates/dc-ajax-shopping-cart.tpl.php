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
 * - $products_list_html: Products list as HTML content.
 * - $shipping: If you have included shipping prices then this variable will be
 *   available. This is an array containing the details of the shipping you have
 *   included in order. If you have not included shipping in your order then
 *   this variable will not be available.
 * - $configuration['show_labels']: Check whether to display labels in cart.
 * - $configuration['remove_cart']: Check whether to display link or image in
 *   for the option remove product from cart.
 * - $configuration['display_tax']: Check whether to display tax.
 * - $configuration['empty_cart_message']: Message to display if the cart is
 *   empty.
 * If you want to make changes in the structure Shopping Cart, copy this file to
 * your theme's templates directory. DO NOT change this file.
 */
?>

<?php $content = ''; ?>
<?php if($order && $quantity != 0): ?>
  <!-- Order object present and cart is not empty. -->
  <div class="ajax-shopping-cart-wrapper">
    <?php print $products_list_html; ?>

    <div class="ajax-shopping-cart-more-info clearfix">
      <?php if (!empty($shipping)): ?>
        <div class="ajax-shopping-cart-shipping">
          <?php print $shipping['service'] . ' ' . $shipping['price']; ?>
        </div>
      <?php endif; ?>

      <div class="ajax-shopping-cart-total">
        <?php print t('Total:') . ' ' . $product_price_total; ?>
      </div>
      <div class="ajax-shopping-cart-checkout">
        <?php print $checkout_url; ?>
      </div>
    </div>
  </div>
<?php elseif($quantity == 0 || !$order): ?>
  <!-- Cart is empty or order object is null. -->
  <div class="ajax-shopping-cart-wrapper">
    <div class="empty-shopping-cart">
      <?php print $configuration['empty_cart_message']; ?>
    </div>
    <div class="ajax-shopping-cart-total"></div>
    <div class="ajax-shopping-cart-checkout"></div>
  </div>
<?php endif; ?>
