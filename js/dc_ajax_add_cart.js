(function ($, Drupal, window, document, undefined) {
  Drupal.behaviors.dcAjaxAddCart = {
    attach: function (context, settings) {
      $('body').delegate('.add-to-cart-close', 'click', function() {
        $('#add-to-cart-overlay').fadeOut('fast');
        $('.add-cart-message-wrapper').css('display', 'none');
      });
    }
  };
})(jQuery, Drupal, this, this.document);
