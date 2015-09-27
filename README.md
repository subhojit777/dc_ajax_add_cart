[![Build Status](https://travis-ci.org/subhojit777/dc_ajax_add_cart.svg?branch=7.x-2.x)](https://travis-ci.org/subhojit777/dc_ajax_add_cart)

Using this module you can ajaxify the add to cart operation. The updated cart will be displayed without page refresh and a popup message will be shown after you add an item to cart. You can customize the look of the blocks using its template files.

Features:
---------
- Shopping cart block (minified version of cart page), that updates every time you add product to cart.
- Remove product from cart through AJAX
- Pop up message will appear showing the current item you have added to cart.
- Update product quantity in cart itself

Installation and usage:
-----------------------
- Install the module in a Drupal Commerce installation. Steps for installing module in Drupal can be found [here](http://drupal.org/documentation/install/modules-themes/modules-7).
- Go to blocks page `admin/structure/block` and place the blocks called **AJAX shopping cart** and **AJAX shopping cart teaser** in desired regions. If you are working on [Commerce Kickstart](https://www.drupal.org/project/commerce_kickstart) distribution and have "Commerce Kickstart Theme" as the default theme then it would be best if you put block "AJAX shopping cart" in "Sidebar Second" region and AJAX Custom shopping cart teaser" in "User Bar Second" region. Remove the default block from "User Bar Second" region.
- This module provides a popup message that the product item has been successfully added to cart. By default Commerce Kickstart distribution also provides a similar kind of popup message that appears on page refresh. You can disable the default popup message if you disable this rule: "Kickstart Add to Cart message".
- This module provides template files to provide further customizations. Copy the template files in theme's templates directory and make desired changes.
- Configuration of the module can be found on this page `admin/commerce/config/ajax-cart`.

Maintainer:
-----------
Subhojit Paul ([subhojit777](https://www.drupal.org/u/subhojit777))

Credits:
----------
Icons taken fron http://iconfinder.com
