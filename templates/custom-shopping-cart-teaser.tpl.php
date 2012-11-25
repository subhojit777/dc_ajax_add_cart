<?php
  /**
   * Available variables:
   * - $order: Order object for the current user.
   * - $quantity: Number of items present in the cart.
   * - $total: Array containing the total amount and default currency code used
   *   in the site.
   *
   * Other variables:
   * - $total_amount: A formatted string that consists of the total amount and
   *   currency setting of AJAX Add to Cart. Placement of currency code or
   *   symbol is based on the Drupal currency setting.
   *
   * If you want to change the structure of Cart Teaser then copy this file to
   * your theme's templates directory and make your changes.
   *
   * DO NOT change this file.
   */
?>

<?php if($order && $quantity != 0): ?>
  <!-- Order object is not null and cart is not empty. -->
  <div class="custom-shopping-cart-teaser">
    <div class="cart-image">
      <img src="<?php echo base_path() . drupal_get_path('module', 'ajax_add_to_cart') . '/images/shopping-cart.png' ?>" />
    </div>
    <div class="cart-product-quantity">
      <?php echo l(($quantity > 1) ? ($quantity . ' ' . variable_get('item_suffix_text') . 's') : ($quantity . ' ' . variable_get('item_suffix_text')), 'cart', array('attributes' => array('class' => array('quantity')))); ?>
    </div>
    <div class="cart-product-total">
      <p class="total-amount">
        <?php echo $total_amount; ?>
      </p>
    </div>
  </div>
<?php elseif($quantity == 0 || !$order): ?>
  <!-- Cart is empty or order object is null. -->
  <div class="custom-shopping-cart-teaser">
    <div class="cart-image">
      <img src="<?php echo base_path() . drupal_get_path('module', 'ajax_add_to_cart') . '/images/shopping-cart.png' ?>" />
    </div>
    <div class="cart-product-quantity">
      <p class="empty-cart">
        <?php echo variable_get('empty_cart_teaser_message'); ?>
      </p>
    </div>
    <div class="cart-product-total">
      <p class="total-amount">
        <?php echo $total_amount; ?>
      </p>
    </div>
  </div>
<?php endif; ?>
