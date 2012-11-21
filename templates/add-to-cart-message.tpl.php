<?php
  /**
   * Available variables:
   * - $line_item: The line item object recently ordered.
   * - $product: The product object recently added to cart.
   *
   * Other variables:
   * - $product_per_unit_price: Per unit price of the product. It has currency
   *   code or symbol attached to it. Currency code or symbol depends on the
   *   AJAX Add to Cart settings.
   * - $product_price_total: Total price of the product. It has currency
   *   code or symbol attached to it. Currency code or symbol depends on the
   *   AJAX Add to Cart settings.
   * - $product_image_url: Image url of the product. This will be empty if the
   *   product has no image.
   *   This variable is always empty even though image for the product is
   *   available - BUG
   *
   * If you want to change the structure of Add to Cart Message popup, then copy
   * this file to your theme's templates directory and do your changes.
   *
   * DO NOT change this file.
   */
?>

<div class="add-to-cart-overlay" id="add-to-cart-overlay"></div>
<div class="add-cart-message-wrapper">
  <!-- Close button. -->
  <a class="add-to-cart-close">
    <span class="element-invisible">
      <?php echo t('Close'); ?>
    </span>
  </a>
  <div class="added-product-message">
    <?php echo variable_get('success_message'); ?>
  </div>
  <div class="option-button-wrapper">
    <!-- Checkout link. -->
    <div class="option-button checkout">
      <?php echo l(variable_get('popup_checkout'), 'cart'); ?>
    </div>
    <!-- Continue shopping. -->
    <div class="option-button continue">
      <span class="add-to-cart-close">
        <?php echo variable_get('popup_continue_shopping'); ?>
      </span>
    </div>
  </div>
  <div class="new-item-details">
    <!-- Product name. -->
    <?php if (variable_get('popup_product_name_display') == 1): ?>
      <div class="product-name">
        <?php if (variable_get('popup_product_name_label') == 'display_label'): ?>
          <p class="name-label">
            <?php echo t('Name:'); ?>
          </p>
        <?php endif; ?>
        <p class="name">
          <?php echo $product->title; ?>
        </p>
      </div>
    <?php endif; ?>
    <!-- Product cost including tax. -->
    <?php if (variable_get('popup_product_price_display') == 1): ?>
      <div class="product-cost-incl-tax">
        <?php if (variable_get('popup_product_price_label') == 'display_label'): ?>
          <p class="cost-incl-tax-label">
            <?php echo t('Price:'); ?>
          </p>
        <?php endif; ?>
        <p class="cost-incl-tax">
          <?php echo $product_per_unit_price; ?>
        </p>
      </div>
    <?php endif; ?>
    <?php if (variable_get('popup_product_quantity_display') == 1): ?>
    <!-- Product quantity. -->
    <div class="product-quantity">
      <?php if (variable_get('popup_product_quantity_label') == 'display_label'): ?>
        <p class="quantity-label">
          <?php echo t('Quantity:'); ?>
        </p>
      <?php endif; ?>
      <p class="quantity">
        <?php echo intval($line_item->quantity); ?>
      </p>
    </div>
    <?php endif; ?>
    <?php if (variable_get('popup_product_total_display') == 1): ?>
    <!-- Product total including tax. -->
    <div class="product-total-incl-tax">
      <?php if (variable_get('popup_product_total_label') == 'display_label'): ?>
        <p class="total-label">
          <?php echo t('Total:'); ?>
        </p>
      <?php endif; ?>
      <p class="total-incl-tax">
        <?php echo $product_price_total; ?>
      </p>
    </div>
    <?php endif; ?>
  </div>
</div>
