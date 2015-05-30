(function ($, Drupal, window, document, undefined) {
  Drupal.behaviors.dcAjaxAddCart = {
    attach: function (context, settings) {
      $('body').delegate('[data-dismiss="add-cart-message"]', 'click', function() {
        $('#add-to-cart-overlay').fadeOut('fast');
        $('.add-cart-message-wrapper').css('display', 'none');
      });
    }
  };
})(jQuery, Drupal, this, this.document);
