/**
 * @file
 * Creates a Ajax 'replace' command.
 *
 * This command is specifically for dc_ajax_add_cart module.
 * Unlike `ajax_command_replace()`, this command will not produce extra div
 * wrapper with 'display: block' style.
 */

(function ($) {
  Drupal.ajax.prototype.commands.dc_ajax_add_cart_html = function(ajax, response, status) {
    $(response.selector).html(response.data);
  };
})(jQuery);
