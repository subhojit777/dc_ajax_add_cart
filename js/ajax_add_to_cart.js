(function ($, Drupal, window, document, undefined) {
	$('.add-to-cart-close').live('click', function() {
    $('#add-to-cart-overlay').fadeOut('fast');
    $('.add-cart-message-wrapper').css('display', 'none');
	});
})(jQuery, Drupal, this, this.document);
