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
    // Get information from the response. If it is not there, default to
    // our presets.
    var wrapper = response.selector ? $(response.selector) : $(ajax.wrapper);

    var new_content = $(response.selector).html(response.data);

    // If removing content from the wrapper, detach behaviors first.
    var settings = response.settings || ajax.settings || Drupal.settings;
    Drupal.detachBehaviors(wrapper, settings);

    // Attach all JavaScript behaviors to the new content, if it was successfully
    // added to the page, this if statement allows #ajax['wrapper'] to be
    // optional.
    if (new_content.parents('html').length > 0) {
      // Apply any settings from the returned JSON if available.
      var settings = response.settings || ajax.settings || Drupal.settings;
      Drupal.attachBehaviors(new_content, settings);
    }
  };
})(jQuery);
