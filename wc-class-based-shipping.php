<?php
/**
 * Plugin Name:         Class Based Shipping for WooCommerce
 * Plugin URI:          https://uniserv.com.au/software/wordpress/wc-class-based-shipping/
 * Description:         Define class-based shipping methods for WooCommerce products.
 * Version:             1.1
 * Requires at least:   5.5
 * Requires PHP:        7.0
 * Author:              Lucian Kafka
 * Author URI:          https://uniserv.com.au/software/wordpress/
 * License:             GPLv2
 * License URI:         https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @package wc-class-based-shipping
 */

add_action('woocommerce_load_shipping_methods', 'cbs_woocommerce_load_shipping_methods', 10, 1);

function cbs_woocommerce_load_shipping_methods($package = array()) {
    $default_shipping = WC()->shipping();
    
    if (!is_admin()) { // && !wp_doing_ajax()) {

        $special_shipping_classes = [];

        foreach ($default_shipping->get_shipping_classes() as $shipping_class) {
            if (preg_match('/CLASS_BASED_SHIPPING\((([a-z0-9\-\_\ ]+[\,]?)+)\)/is', $shipping_class->description, $matches) && isset($matches[1])) {
                // ie. CLASS_BASED_SHIPPING(flat_rate, local_pickup)
                $special_shipping_classes[$shipping_class->slug] = array_map('trim', explode(',', $matches[1]));
            }
        }

        if (!empty($special_shipping_classes)) { // if CLASS_BASED_SHIPPINGis defined
            $change_shipping_methods = null;

            // Checking in cart items
            foreach (WC()->cart->get_cart() as $cart_item) {
                $item_shipping_class = $cart_item['data']->get_shipping_class();

                foreach ($special_shipping_classes as $special_class_slug => $allowed_shipping_methods) {
                    if ($item_shipping_class == $special_class_slug) {
                        $change_shipping_methods = $allowed_shipping_methods;
                        break; // stops at first match - only match one special class per CART
                    }
                }

                if ($change_shipping_methods) {
                    break;
                }
            }

            if ($change_shipping_methods) {
                if (!empty($package)) {
                    $shipping_zone = WC_Shipping_Zones::get_zone_matching_package($package);
                    $shipping_methods = $shipping_zone->get_shipping_methods(false); // get all methods available, even disabled
                } else {
                    $shipping_methods = array();
                }

                foreach ($shipping_methods as $key => $shipping_method) {
                    $shipping_method->enabled = 'yes';
                    if (!in_array($shipping_method->id, $change_shipping_methods)) {
                        unset($shipping_methods[$key]);
                    }
                }

                if (!empty($shipping_methods)) {
                    $default_shipping->shipping_methods = $shipping_methods; // change default shipping methods
                }
            }
        }
    }
    return $default_shipping->shipping_methods; // return default shipping methods in case we have no match
}
