AJAX Add to Cart module ajaxifies the add to cart operation. The updated cart
will be displayed without page refresh and a popup message will be shown after
you add an item to cart. This module provides two blocks, first the shopping
cart block that provides details of the product currently present in the cart,
and the other is a shopping cart teaser that provides the total number of items 
and the total amount including tax. You can customize the look of the blocks
using its template files.


Usage:
------
1> Install the module in a Drupal Commerce installation. Steps for installing
   module in Drupal can be found here:
   http://drupal.org/documentation/install/modules-themes/modules-7
2> Go to blocks page admin/structure/block and place the blocks called
   "AJAX shopping cart" and "AJAX shopping cart teaser" in desired regions.
   If you are working on Commerce Kickstart distribution and have
   "Commerce Kickstart Theme" as the default theme then it would be best if you
   put block "AJAX shopping cart" in "Sidebar Second" region and
   AJAX Custom shopping cart teaser" in "User Bar Second" region. Remove the
   default block from "User Bar Second" region.
3> This module provides a popup message that the product item has been
   successfully added to cart. By default Commerce Kickstart distribution also
   provides a similar kind of popup message that appears on page refresh.
   You can disable the default popup message if you disable this rule:
   "Kickstart Add to Cart message".
4> Configuration of the module can be found on this page:
   admin/commerce/config/ajax-cart.
5> This module provides template files to provide further customizations. Copy
   the template files in theme's templates directory and make desired changes.
   

Mentor:
-------
Mukesh Agarwal
mukesh.agarwal17<mukesh.agarwal@innoraft.com>

Maintainer:
-----------
Subhojit Paul
subhojit777<subhojit_19@yahoo.in>

Resources:
----------
Icons taken fron iconfinder.com
