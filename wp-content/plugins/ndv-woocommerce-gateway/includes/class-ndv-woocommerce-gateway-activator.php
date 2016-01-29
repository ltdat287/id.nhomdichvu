<?php

/**
 * Fired during plugin activation
 *
 * @link       http://nhomdichvu.com
 * @since      1.0.0
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 * @author     DinhLN <lenhatdinh@gmail.com>
 */
class Ndv_Woocommerce_Gateway_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        if ( ! wp_next_scheduled( 'ndv_auto_handle_order' ) ) {
            wp_schedule_event( time(), 'every_15_minute', 'ndv_auto_handle_order' );
        }

        if ( ! wp_next_scheduled( 'ndv_auto_handle_subscription' ) ) {
            wp_schedule_event( time(), 'every_15_minute', 'ndv_auto_handle_subscription' );
        }
    }

}
