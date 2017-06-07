<?php

/**
 * @file
 * Helper functions.
 */

/**
 * Includes resources required to make the carts functionable.
 */
function dc_ajax_add_cart_include_cart_resources() {
  drupal_add_css(drupal_get_path('module', 'dc_ajax_add_cart') . '/css/dc_ajax_add_cart.css');
  drupal_add_js(drupal_get_path('module', 'dc_ajax_add_cart') . '/js/dc_ajax_add_cart_html.js');
}
