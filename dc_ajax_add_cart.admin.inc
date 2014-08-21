<?php

/**
 * @file
 * Ajax add to cart administration UI.
 */

/**
 * Commerce AJAX Add to Cart settings form.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_ajax_cart_settings_form($form, &$form_state) {
  $form['dc_ajax_add_cart_checkout_redirect'] = array(
    '#type' => 'select',
    '#title' => t('Checkout button redirect'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_CHECKOUT_REDIRECT, 'cart_page'),
    '#options' => array(
      'cart_page' => t('Cart page'),
      'checkout_page' => t('Checkout page'),
    ),
    '#decription' => t('Configure where you want to redirect after clicking checkout button on AJAX Shopping Cart.'),
  );

  $form['dc_ajax_add_cart_show_labels'] = array(
    '#type' => 'radios',
    '#title' => t('Show labels'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_SHOW_LABELS, 'label'),
    '#options' => array(
      'label' => t('Yes'),
      'no_label' => t('No'),
    ),
    '#description' => t('Configure whether you want to show labels in AJAX Shopping Cart'),
  );

  $form['dc_ajax_add_cart_empty_cart_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Empty cart message'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_EMPTY_CART_MESSAGE, t('Shopping cart is empty')),
    '#description' => t('Message that will be displayed if the cart is empty.'),
  );

  $form['dc_ajax_add_cart_remove_cart'] = array(
    '#type' => 'select',
    '#title' => t('Remove cart'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_REMOVE_CART, 'link'),
    '#options' => array(
      'link' => t('Display remove from cart as link'),
      'image' => t('Display remove from cart as image'),
    ),
    '#description' => t('Configure how you want to display the Remove from Cart button'),
  );

  $form['dc_ajax_add_cart_hide_empty_cart'] = array(
    '#type' => 'checkbox',
    '#title' => t('Hide empty cart'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_HIDE_EMPTY_CART, 0),
    '#description' => t('Check this if you want to hide cart if it is empty'),
  );

  $form['dc_ajax_add_cart_update_quantity'] = array(
    '#type' => 'checkbox',
    '#title' => t('Updateable product quantity'),
    '#default_value' => variable_get('dc_ajax_add_cart_update_quantity', 0),
    '#description' => t('Check this if you want to update the product quantity in the shopping cart itself. Note that the update operation is also AJAX.'),
  );

  $form['#submit'][] = 'dc_ajax_add_cart_ajax_cart_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Submit handler for shopping cart block settings.
 *
 * It ensures that any string setting is translatable and sanitized.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_ajax_cart_settings_form_submit($form, &$form_state) {
  switch ($form_state['values']) {
    case 'dc_ajax_add_cart_empty_cart_message':
      $form_state['values']['dc_ajax_add_cart_empty_cart_message'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_empty_cart_message']));

      break;
  }
}

/**
 * Commerce AJAX Add to Cart teaser settings.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_cart_teaser_settings_form($form, &$form_state) {
  $form['dc_ajax_add_cart_empty_cart_teaser_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Empty cart message'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_EMPTY_CART_TEASER_MESSAGE, t('Empty')),
    '#description' => t('Message that will be displayed on cart teaser if cart is empty.'),
  );

  $form['dc_ajax_add_cart_item_suffix_text'] = array(
    '#type' => 'textfield',
    '#title' => t('Item suffix text'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_ITEM_SUFFIX_TEXT, t('item')),
    '#description' => t('Suffix text that will be displayed after the number of items in cart teaser. Multiple items will be detected and the text will be changed according to that.'),
  );

  $form['#submit'][] = 'dc_ajax_add_cart_cart_teaser_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Submit handler for shopping cart teaser block.
 *
 * It ensures that any string setting is translatable and sanitized.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_cart_teaser_settings_form_submit($form, &$form_state) {
  switch ($form_state['values']) {
    case 'dc_ajax_add_cart_empty_cart_teaser_message':
      $form_state['values']['dc_ajax_add_cart_empty_cart_teaser_message'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_empty_cart_teaser_message']));

      break;

    case 'dc_ajax_add_cart_item_suffix_text':
      $form_state['values']['dc_ajax_add_cart_item_suffix_text'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_item_suffix_text']));

      break;
  }
}

/**
 * Popup message settings.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_message_settings_form($form, &$form_state) {
  $form['dc_ajax_add_cart_display_popup'] = array(
    '#type' => 'radios',
    '#title' => t('Display popup message'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_DISPLAY_POPUP, 'display_popup_message'),
    '#options' => array(
      'display_popup_message' => t('Yes'),
      'no_display_popup_message' => t('No'),
    ),
    '#description' => t('Configure whether you want to display a popup message after adding item to cart.'),
  );

  $form['dc_ajax_add_cart_success_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Success message'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_SUCCESS_MESSAGE, t('Item successfully added to cart')),
    '#description' => t('Success message that will appear on popup after adding item to cart.'),
  );

  $form['product_details_popup'] = array(
    '#type' => 'fieldset',
    '#title' => t('Product details in popup'),
    '#description' => t('Configure what product details you want to show in popup.'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  // Product name display setting.
  $form['product_details_popup']['dc_ajax_add_cart_popup_product_name_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Product name'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_NAME_DISPLAY, 1),
    '#disabled' => TRUE,
    '#ajax' => array(
      'callback' => 'dc_ajax_add_cart_popup_product_name_callback',
      'wrapper' => 'popup-product-name-label-setting-wrapper',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );

  $form['product_details_popup']['popup_product_name_label_wrapper'] = array(
    '#prefix' => '<div id="popup-product-name-label-setting-wrapper">',
    '#suffix' => '</div>',
  );

  // Product quantity display setting.
  $form['product_details_popup']['dc_ajax_add_cart_popup_product_quantity_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Product quantity'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_QUANTITY_DISPLAY, 1),
    '#ajax' => array(
      'callback' => 'dc_ajax_add_cart_popup_product_quantity_callback',
      'wrapper' => 'popup-product-quantity-label-setting-wrapper',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );

  $form['product_details_popup']['popup_product_quantity_label_wrapper'] = array(
    '#prefix' => '<div id="popup-product-quantity-label-setting-wrapper">',
    '#suffix' => '</div>',
  );

  // Product price dislpay setting.
  $form['product_details_popup']['dc_ajax_add_cart_popup_product_price_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Product price'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_PRICE_DISPLAY, 1),
    '#ajax' => array(
      'callback' => 'dc_ajax_add_cart_popup_product_price_callback',
      'wrapper' => 'popup-product-price-label-setting-wrapper',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );

  $form['product_details_popup']['popup_product_price_label_wrapper'] = array(
    '#prefix' => '<div id="popup-product-price-label-setting-wrapper">',
    '#suffix' => '</div>',
  );

  // Product total display setting.
  $form['product_details_popup']['dc_ajax_add_cart_popup_product_total_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Product total'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_TOTAL_DISPLAY, 1),
    '#disabled' => TRUE,
    '#ajax' => array(
      'callback' => 'dc_ajax_add_cart_popup_product_total_callback',
      'wrapper' => 'popup-product-total-label-setting-wrapper',
      'method' => 'replace',
      'effect' => 'fade',
    ),
  );

  $form['product_details_popup']['popup_product_total_label_wrapper'] = array(
    '#prefix' => '<div id="popup-product-total-label-setting-wrapper">',
    '#suffix' => '</div>',
  );

  $form['dc_ajax_add_cart_popup_checkout'] = array(
    '#type' => 'textfield',
    '#title' => t('Checkout text'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_CHECKOUT, t('Go to checkout')),
    '#description' => t('Configure the text you want to show in checkout link.'),
  );

  $form['dc_ajax_add_cart_popup_continue_shopping'] = array(
    '#type' => 'textfield',
    '#title' => t('Continue shopping text'),
    '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_CONTINUE_SHOPPING, t('Continue shopping')),
    '#description' => t('Configure the text you want to show in continue shopping link.'),
  );

  // Product name label setting AJAX form.
  if (empty($form_state['values']) && variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_NAME_DISPLAY, 1) == 1) {
    $form['product_details_popup']['popup_product_name_label_wrapper']['dc_ajax_add_cart_popup_product_name_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_NAME_LABEL, 'no_display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product name.'),
    );
  }

  if (!empty($form_state['values']['dc_ajax_add_cart_popup_product_name_display'])
    && $form_state['values']['dc_ajax_add_cart_popup_product_name_display'] == 1) {
    $form['product_details_popup']['popup_product_name_label_wrapper']['dc_ajax_add_cart_popup_product_name_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_NAME_LABEL, 'no_display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product name.'),
    );
  }

  // Product quantity label setting AJAX form.
  if (empty($form_state['values']) && variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_QUANTITY_DISPLAY, 1) == 1) {
    $form['product_details_popup']['popup_product_quantity_label_wrapper']['dc_ajax_add_cart_popup_product_quantity_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_QUANTITY_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product quantity.'),
    );
  }

  if (!empty($form_state['values']['dc_ajax_add_cart_popup_product_quantity_display']) && $form_state['values']['dc_ajax_add_cart_popup_product_quantity_display'] == 1) {
    $form['product_details_popup']['popup_product_quantity_label_wrapper']['dc_ajax_add_cart_popup_product_quantity_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_QUANTITY_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product quantity.'),
    );
  }

  // Product price label setting AJAX form.
  if (empty($form_state['values']) && variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_PRICE_DISPLAY, 1) == 1) {
    $form['product_details_popup']['popup_product_price_label_wrapper']['dc_ajax_add_cart_popup_product_price_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_PRICE_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product price.'),
    );
  }

  if (!empty($form_state['values']['dc_ajax_add_cart_popup_product_price_display']) && $form_state['values']['dc_ajax_add_cart_popup_product_price_display'] == 1) {
    $form['product_details_popup']['popup_product_price_label_wrapper']['dc_ajax_add_cart_popup_product_price_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_PRICE_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product price.'),
    );
  }

  // Product total label setting AJAX form.
  if (empty($form_state['values']) && variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_TOTAL_DISPLAY, 1) == 1) {
    $form['product_details_popup']['popup_product_total_label_wrapper']['dc_ajax_add_cart_popup_product_total_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_TOTAL_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product total.'),
    );
  }

  if (!empty($form_state['values']['dc_ajax_add_cart_popup_product_total_display']) && $form_state['values']['dc_ajax_add_cart_popup_product_total_display'] == 1) {
    $form['product_details_popup']['popup_product_total_label_wrapper']['dc_ajax_add_cart_popup_product_total_label'] = array(
      '#type' => 'radios',
      '#title' => t('Display label'),
      '#default_value' => variable_get(DC_AJAX_ADD_CART_POPUP_PRODUCT_TOTAL_LABEL, 'display_label'),
      '#options' => array(
        'display_label' => t('Yes'),
        'no_display_label' => t('No'),
      ),
      '#description' => t('Configure whether you want to show label beside product total.'),
    );
  }

  $form['#submit'][] = 'dc_ajax_add_cart_popup_message_settings_form_submit';

  return system_settings_form($form);
}

/**
 * Submit handler for shopping cart teaser block.
 *
 * It ensures that any string setting is translatable and sanitized.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_message_settings_form_submit($form, &$form_state) {
  switch ($form_state['values']) {
    case 'dc_ajax_add_cart_success_message':
      $form_state['values']['dc_ajax_add_cart_success_message'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_success_message']));

      break;

    case 'dc_ajax_add_cart_popup_checkout':
      $form_state['values']['dc_ajax_add_cart_popup_checkout'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_popup_checkout']));

      break;

    case 'dc_ajax_add_cart_popup_continue_shopping':
      $form_state['values']['dc_ajax_add_cart_popup_continue_shopping'] = t('@check_plain', array('@check_plain' => $form_state['values']['dc_ajax_add_cart_popup_continue_shopping']));

      break;
  }
}

/**
 * Callback function for rendering name label setting form.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_product_name_callback($form, &$form_state) {
  return $form['product_details_popup']['popup_product_name_label_wrapper'];
}

/**
 * Callback function for rendering quantity label setting form.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_product_quantity_callback($form, &$form_state) {
  return $form['product_details_popup']['popup_product_quantity_label_wrapper'];
}

/**
 * Callback function for rendering price label setting form.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_product_price_callback($form, &$form_state) {
  return $form['product_details_popup']['popup_product_price_label_wrapper'];
}

/**
 * Callback function for rendering total label setting form.
 *
 * @ingroup forms
 */
function dc_ajax_add_cart_popup_product_total_callback($form, &$form_state) {
  return $form['product_details_popup']['popup_product_total_label_wrapper'];
}
