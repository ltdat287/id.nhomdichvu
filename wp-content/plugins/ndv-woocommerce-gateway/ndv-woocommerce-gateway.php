<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://nhomdichvu.com
 * @since             1.0.0
 * @package           Ndv_WooCommerce_Gateway
 *
 * @wordpress-plugin
 * Plugin Name:       NDV WooCommerce Gateway
 * Plugin URI:        http://nhomdichvu.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            DinhLN
 * Author URI:        http://nhomdichvu.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ndv-woocommerce-gateway
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ndv-woocommerce-gateway-activator.php
 */
function activate_ndv_woocommerce_gateway()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ndv-woocommerce-gateway-activator.php';
    Ndv_Woocommerce_Gateway_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ndv-woocommerce-gateway-deactivator.php
 */
function deactivate_ndv_woocommerce_gateway()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-ndv-woocommerce-gateway-deactivator.php';
    Ndv_Woocommerce_Gateway_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_ndv_woocommerce_gateway');
register_deactivation_hook(__FILE__, 'deactivate_ndv_woocommerce_gateway');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ndv-woocommerce-gateway.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ndv_woocommerce_gateway()
{

    $plugin = new Ndv_Woocommerce_Gateway();
    $plugin->run();
    return $plugin;

}

$plugin = run_ndv_woocommerce_gateway();

if (! function_exists('dd')) {
    function dd($data)
    {
        var_dump($data);die();
    }
}

/**
 * @param string $time
 * @return string
 */
function dln_format_date( $time = '' )
{
    return date_i18n( get_option( 'date_format' ), strtotime( $time ) );
}

/**
 * @return false|string
 */
function dln_get_avatar()
{
    $user   = wp_get_current_user();
    $avatar = '';
    if ( $user->ID ) {
        $facebook_login_id = get_user_meta( $user->ID, 'facebook_login_id', true );
        if ( $facebook_login_id ) {
            $avatar = "https://graph.facebook.com/{$facebook_login_id}/picture?type=normal";
        } else {
            $avatar = get_avatar_data( $user->user_email );
            $avatar = ( ! empty( $avatar['url'] ) ) ? $avatar['url'] : '';
        }
    }

    return $avatar;
}

/**
 * Debug actions.
 *
 * @param array $wp
 * @return void
 */
function ndv_parse_request( $wp = array() ) {
    if ( isset( $_GET['ndv-action'] ) ) {
        $action_name = $_GET['ndv-action'];

        if ( $action_name ) {
            do_action( $action_name );
        }
    }
}
add_action('parse_request', 'ndv_parse_request');

define( 'NDV_WOO', $plugin->get_plugin_name() );
define( 'NDV_WOO_VER', $plugin->get_version() );
define( 'NDV_WOO_PATH', plugin_dir_path( __FILE__ ) );
define( 'NDV_WOO_URL', plugin_dir_url( __FILE__ ) );
define( 'JWT_AUTH_SECRET_KEY', 'p[,k: a&fOV-2J0MY3/qF}0$**B*`*Yf+<FJvl|J)n#eRyl&O8lh;SnaG-sh+<dV' );
define( 'JWT_AUTH_CORS_ENABLE', true );
define( 'NDV_USE_SHARE', false );