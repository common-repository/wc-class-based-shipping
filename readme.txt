=== Class Based Shipping for WooCommerce — Define shipping methods per shipping class ===
Plugin URI:        https://uniserv.com.au/software/wordpress/wc-class-based-shipping/
Tags:              shipping, shipping class, shipping method, class based shipping, customize shipping
Requires at least: 5.5
Tested up to:      6.0
Requires PHP:      7.0
Stable tag:        1.1
License:           GPL-2.0
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

Define the available shipping methods for your products on a per shipping class basis.

== Description ==

This free plugin allows you to customize with ease the shipping methods available for each shipping class, so that you can offer different shipping options per product class.

== How does it work? ==

Simply create or edit an existing shipping class, and set the available shipping methods in the Description field of the shipping class (see below syntax). The plugin will then the default shipping methods to the ones specified when one or more items in the cart match the customized shipping methods class.

== Custom syntax ==

To customize the available shipping methods for a WooCommerce shipping class, simply use the following plugin syntax inside the description field of the shipping class: CLASS_BASED_SHIPPING(shipping_method_1_id, shipping_method_2_id [, etc])

For example, one may wish to have a shipping class for products which can be picked up locally or shipped using a flat rate method: CLASS_BASED_SHIPPING(flat_rate, local_pickup)

The class description field may also include additional text, as long as it does not interfere with the syntax of the plugin tag above.

