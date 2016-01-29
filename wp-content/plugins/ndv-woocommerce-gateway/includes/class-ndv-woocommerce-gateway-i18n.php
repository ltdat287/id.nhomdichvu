<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://nhomdichvu.com
 * @since      1.0.0
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 * @author     DinhLN <lenhatdinh@gmail.com>
 */
class Ndv_Woocommerce_Gateway_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'ndv-woocommerce-gateway',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }


}
