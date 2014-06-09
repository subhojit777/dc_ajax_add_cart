<?php

/**
 * @file
 * Ajax shopping cart teaser block template file.
 */

/**
 * Available variables:
 * - $order: Order object for the current user.
 * - $quantity: Number of items present in the cart.
 * - $total: Array containing the total amount and default currency code used
 *   in the site.
 * Other variables:
 * - $total_amount: A formatted string that consists of the total amount and
 *   currency setting of AJAX Add to Cart. Placement of currency code or
 *   symbol is based on the Drupal currency setting.
 * - $cart_icon: Cart icon.
 * - $configuration['empty_cart_teaser_message']: Message to show if the cart
 *   is empty.
 * - $cart_link: Link in teaser block that takes you to cart page.
 *   is empty.
 * If you want to change the structure of Cart Teaser then copy this file to
 * your theme's templates directory and make your changes. DO NOT change this
 * file.
 */
?>

<?php if($order && $quantity != 0): ?>
  <!-- Order object is not null and cart is not empty. -->
  <div class="ajax-shopping-cart-teaser">
    <div class="cart-image">
      <?php print $cart_icon; ?>
    </div>
    <div class="cart-product-quantity">
      <?php print $cart_link; ?>
    </div>
    <div class="cart-product-total">
      <p class="total-amount">
        <?php print $total_amount; ?>
      </p>
    </div>
  </div>
<?php elseif($quantity == 0 || !$order): ?>
  <!-- Cart is empty or order object is null. -->
  <div class="ajax-shopping-cart-teaser">
    <div class="cart-image">
      <?php print $cart_icon; ?>
    </div>
    <div class="cart-product-quantity">
      <p class="empty-cart">
        <?php print $configuration['empty_cart_teaser_message']; ?>
      </p>
    </div>
    <div class="cart-product-total">
      <p class="total-amount">
        <?php print $total_amount; ?>
      </p>
    </div>
  </div>
<?php endif; ?>
