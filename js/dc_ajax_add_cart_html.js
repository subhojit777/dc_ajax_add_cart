(function ($) {
  Drupal.ajax.prototype.commands.dc_ajax_add_cart_html = function(ajax, response, status) {
    $(response.selector).html(response.data);
  };
})(jQuery);
