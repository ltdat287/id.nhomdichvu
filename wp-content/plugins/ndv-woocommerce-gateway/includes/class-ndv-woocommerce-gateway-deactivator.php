<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://nhomdichvu.com
 * @since      1.0.0
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 * @author     DinhLN <lenhatdinh@gmail.com>
 */
class Ndv_Woocommerce_Gateway_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        wp_clear_scheduled_hook( 'ndv_auto_handle_order' );
        wp_clear_scheduled_hook( 'ndv_auto_handle_subscription' );
    }

}
