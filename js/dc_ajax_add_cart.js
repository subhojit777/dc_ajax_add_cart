/**
 * @file
 * Ajax add to cart module.
 */

(function ($, Drupal, window, document, undefined) {
  Drupal.behaviors.dcAjaxAddCart = {
    attach: function (context, settings) {
      // Close the add to cart overlay.
      function closeAddToCartOverlay() {
        $('#add-to-cart-overlay').fadeOut('fast');
        $('.add-cart-message-wrapper').css('display', 'none');
      }

      $('body').delegate('[data-dismiss="add-cart-message"]', 'click', closeAddToCartOverlay);
      $(document).keyup(function(e) {
        // Close overlay with esc key.
        if (e.keyCode == 27) {
          closeAddToCartOverlay();
        }
      });
    }
  };
})(jQuery, Drupal, this, this.document);
