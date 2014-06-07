<?php

/**
 * @file
 * Add to cart message template file.
 */

/**
 * Available variables:
 * - $line_item: The line item object recently ordered.
 * - $product: The product object recently added to cart.
 * Other variables:
 * - $product_per_unit_price: Per unit price of the product. It has currency
 *   code or symbol attached to it. Currency code or symbol depends on the
 *   AJAX Add to Cart settings.
 * - $product_price_total: Total price of the product. It has currency
 *   code or symbol attached to it. Currency code or symbol depends on the
 *   AJAX Add to Cart settings.
 * - $configuration['success_message']: Success message to be shown on popup.
 * - $configuration['popup_checkout']: Checkout link text.
 * - $checkout_link: Link to checkout page.
 * - $configuration['popup_continue_shopping']: Continue shopping button text.
 * - $configuration['popup_product_name_display']: Check whether to show the
 *   name of product.
 * - $configuration['popup_product_name_label']: Check whether to display name
 *   label.
 * - $product_name: Product name.
 * - $configuration['popup_product_price_display']: Check whether to show the
 *   per unit price of product.
 * - $configuration['popup_product_price_label']: Check whether to display price
 *   label.
 * - $configuration['popup_product_quantity_display']: Check whether to show
 *   quantity of product.
 * - $configuration['popup_product_quantity_label']: Check whether to display
 *   quantity label.
 * - $configuration['popup_product_total_display']: Check whether to show
 *   product total.
 * - $configuration['popup_product_total_label']: Check whether to display total
 *   label.
 * If you want to change the structure of Add to Cart Message popup, then copy
 * this file to your theme's templates directory and do your changes. DO NOT
 * change this file.
 */
?>

<div class="add-to-cart-overlay" id="add-to-cart-overlay"></div>
<div class="add-cart-message-wrapper">
  <!-- Close button. -->
  <a class="add-to-cart-close">
    <span class="element-invisible">
      <?php print t('Close'); ?>
    </span>
  </a>
  <div class="added-product-message">
    <?php print $configuration['success_message']; ?>
  </div>
  <div class="option-button-wrapper">
    <!-- Checkout link. -->
    <div class="option-button checkout">
      <?php print $checkout_link; ?>
    </div>
    <!-- Continue shopping. -->
    <div class="option-button continue">
      <span class="add-to-cart-close">
        <?php print $configuration['popup_continue_shopping']; ?>
      </span>
    </div>
  </div>
  <div class="new-item-details">
    <!-- Product name. -->
    <?php if ($configuration['popup_product_name_display'] == 1): ?>
      <div class="product-name">
        <?php if ($configuration['popup_product_name_label'] == 'display_label'): ?>
          <p class="name-label">
            <?php print t('Name:'); ?>
          </p>
        <?php endif; ?>
        <p class="name">
          <?php print $product_name; ?>
        </p>
      </div>
    <?php endif; ?>
    <!-- Product cost including tax. -->
    <?php if ($configuration['popup_product_price_display'] == 1): ?>
      <div class="product-cost-incl-tax">
        <?php if ($configuration['popup_product_price_label'] == 'display_label'): ?>
          <p class="cost-incl-tax-label">
            <?php print t('Price:'); ?>
          </p>
        <?php endif; ?>
        <p class="cost-incl-tax">
          <?php print $product_per_unit_price; ?>
        </p>
      </div>
    <?php endif; ?>
    <?php if ($configuration['popup_product_quantity_display'] == 1): ?>
    <!-- Product quantity. -->
    <div class="product-quantity">
      <?php if ($configuration['popup_product_quantity_label'] == 'display_label'): ?>
        <p class="quantity-label">
          <?php print t('Quantity:'); ?>
        </p>
      <?php endif; ?>
      <p class="quantity">
        <?php print intval($quantity); ?>
      </p>
    </div>
    <?php endif; ?>
    <?php if ($configuration['popup_product_total_display'] == 1): ?>
    <!-- Product total including tax. -->
    <div class="product-total-incl-tax">
      <?php if ($configuration['popup_product_total_label'] == 'display_label'): ?>
        <p class="total-label">
          <?php print t('Total:'); ?>
        </p>
      <?php endif; ?>
      <p class="total-incl-tax">
        <?php print $product_price_total; ?>
      </p>
    </div>
    <?php endif; ?>
  </div>
</div>
