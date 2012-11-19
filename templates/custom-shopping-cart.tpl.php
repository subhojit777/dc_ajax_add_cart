<?php
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
 * - $product_image_urls: Array containing the image url of the products stored
 *   in the cart. Suppose, a product has no image then the image url of that
 *   product will be empty.
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
 *   
 * If you want to make changes in the structure Shopping Cart, copy this file to
 * your theme's templates directory.
 * 
 * DO NOT change this file.
 */
?>

<?php $content = ''; // This will hold the HTML of shopping cart. ?>
<?php if($order && $quantity != 0): ?>
  <!-- Order object present and cart is not empty. -->
  <div id="custom-shopping-cart-wrapper" class="custom-shopping-cart-wrapper">
    <div class="custom-shopping-cart-table">
      <?php if(variable_get('show_labels') == 'label'): ?>
        <div class="custom-shopping-cart-labels">
          <?php if (variable_get('product_image') == 'image'): ?>
            <span class="image-label">
              <?php echo t('Image'); ?>
            </span>
          <?php endif; ?>
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
      <div class="custom-shopping-cart-details">
        <!-- Start foreach loop. -->
        <?php foreach ($line_item_list as $line_item) {
          if (property_exists($line_item, 'commerce_product')) {
            $product = commerce_product_load($line_item->commerce_product[LANGUAGE_NONE][0]['product_id']);
            $image_url = '<img src="' . $product_image_urls[$product->product_id] . '" >';
            
            $content .= '<div class="product-line-item product-line-item-id-' . $line_item->line_item_id . '">
                          <span class="' . (variable_get('product_image') == 'image' ? 'image' : 'no-image') . '">' . (variable_get('product_image') == 'image' ? $image_url : '') . '</span>
                          <span class="quantity">' . intval($line_item->quantity) . '</span>
                          <span class="name">' . $product->title . '</span>
                          <span class="price">' . $product_prices[$product->product_id] . '</span>
                          <span class="remove-from-cart">' . l(variable_get('remove_cart') == 'link' ? t('Remove form cart') : '<img src="' . base_path() . drupal_get_path('module', 'ajax_add_to_cart') . '/images/remove-from-cart.png' . '" />', 'remove-product/nojs/' . $line_item->line_item_id, array('attributes' => array('class' => array('use-ajax')), 'html' => TRUE)) . '</span>
                        </div>';
          }
          else if (property_exists($line_item, 'commerce_shipping_service') && isset($shipping)) {
            $content .= '<div class="custom-shopping-cart-shipping">' . $shipping['service'] . ' ' . $shipping['price'] . '</div>';
          }
        }

        if (variable_get('display_tax') == 'display') {
          $wrapper = '<div class="custom-shopping-cart-tax-wrapper">';
          $tax_rates = commerce_tax_rates();
          $tax_rate_content = '';
          
          foreach ($tax_rates as $tax_rate) {
            $tax_rate_content .= '<div class="tax-' . $tax_rate['name'] . '">
                                    <span>' . $tax_rate['display_title'] . '</span>
                                    <span>' . $tax_rate['rate'] * 100 . '%</span>
                                  </div>';
          }
          
          $content .= $wrapper . $tax_rate_content . '</div>';
        } ?>
        <!-- End of foreach loop. -->
        <?php echo $content; // Render the cart with product details ?>
      </div>
    </div>
    <span class="custom-shopping-cart-total">
      <?php echo t('Total:') . ' ' . $product_price_total; ?>
    </span>
    <span class="custom-shopping-cart-checkout">
      <?php echo $checkout_url; ?>
    </span>
  </div>
<?php elseif($quantity == 0 || !$order): ?>
  <!-- Cart is empty or order object is null. -->
  <div id="custom-shopping-cart-wrapper" class="custom-shopping-cart-wrapper">
    <div class="empty-shopping-cart">
      <?php echo variable_get('empty_cart_message'); ?>
    </div>
    <div class="custom-shopping-cart-total"></div>
    <div class="custom-shopping-cart-checkout"></div>
  </div>
<?php endif; ?>
