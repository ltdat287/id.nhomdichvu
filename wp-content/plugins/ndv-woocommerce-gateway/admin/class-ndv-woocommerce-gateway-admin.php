<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://nhomdichvu.com
 * @since      1.0.0
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/admin
 * @author     DinhLN <lenhatdinh@gmail.com>
 */
class Ndv_Woocommerce_Gateway_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_filter( 'woocommerce_paypal_supported_currencies', array( $this, 'enable_custom_currency' ) );
        add_filter( 'woocommerce_checkout_fields', array( $this, 'woocommerce_checkout_fields' ), 99, 1 );
        add_filter( 'wcs_get_subscription', array( $this, 'wcs_get_subscription' ), 99, 1 );

        define( 'NDV_DISABLE_X_TIMES', true );
        if (NDV_DISABLE_X_TIMES) {
            add_filter( 'woocommerce_checkout_cart_item_quantity', array( $this, 'woocommerce_checkout_cart_item_quantity' ), 99, 3 );
            add_filter( 'woocommerce_order_item_quantity_html', array( $this, 'woocommerce_order_item_quantity_html' ), 99, 2 );
        }
//        add_filter( 'woocommerce_is_purchasable', array( $this, 'woocommerce_is_purchasable' ), 99, 2 );

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ndv_Woocommerce_Gateway_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ndv_Woocommerce_Gateway_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ndv-woocommerce-gateway-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ndv_Woocommerce_Gateway_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ndv_Woocommerce_Gateway_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ndv-woocommerce-gateway-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * @param $currency_array
     * @return array
     */
    public function enable_custom_currency($currency_array) {
        $currency_array[] = 'VND';
        return $currency_array;
    }

    /**
     * @return void
     */
    public function ndv_woo_gateway_menu()
    {
        add_menu_page(__('NDV Gateway', 'ndv_woo'), __('NDV Gateway', 'ndv_woo'), 'manage_options', 'ndv-gateway', array($this, 'handle_view'), 'dashicons-groups', null);
        add_submenu_page('ndv-gateway', __('NDV Gateway', 'ndv_woo'), __('NDV Gateway', 'ndv_woo'), 'manage_options', 'ndv-gateway', array($this, 'handle_view'));

    }

    /**
     * @return void
     */
    public function admin_init()
    {
        register_setting('ndv_woo_settings', 'ndv_woo_settings');

        add_settings_section(
            'ndv_woo_setting_section',
            __('Thiết lập SSO.', NDV_WOO),
            array( $this, 'ndv_woo_setting_section_callback' ),
            'ndv_woo_settings'
        );

        add_settings_field(
            'ndv_woo_sso_domain',
            __('Domain chính', NDV_WOO),
            array( $this, 'ndv_woo_setting_field_sso_domain' ),
            'ndv_woo_settings',
            'ndv_woo_setting_section'
        );

    }

    /**
     * @param array $notices
     * @return void
     */
    public function admin_notices($notices = array())
    {

    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function handle_view()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        switch ($action) {
            case 'view':

                $template = dirname(__FILE__) . '/partials/ndv-woo-gateway-single.php';
                break;

            case 'edit':
                $template = dirname(__FILE__) . '/partials/ndv-woo-gateway-edit.php';
                break;

            case 'new':
                $template = dirname(__FILE__) . '/partials/ndv-woo-gateway-new.php';
                break;

            // Show options view
            default:
                $template = dirname(__FILE__) . '/partials/ndv-woocommerce-gateway-admin-options.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Handle the  new and edit form
     *
     * @return void
     */
    public function handle_form()
    {
        if (!isset($_POST['submit_setting'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'ndv_woo_nonce_key')) {
            die(__('Are you cheating?', 'ndv_woo'));
        }

        if (!current_user_can('read')) {
            wp_die(__('Permission Denied!', 'ndv_woo'));
        }

        $errors = array();
        $page_url = admin_url('admin.php?page=ndv-gateway');
        $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;

        $dln_exchange_rate = isset($_POST['dln_exchange_rate']) ? sanitize_text_field($_POST['dln_exchange_rate']) : '';
        $dln_chk_er = isset($_POST['dln_chk_er']) ? sanitize_text_field($_POST['dln_chk_er']) : '';

        // some basic validation
        // bail out if error found
        if ($errors) {
            $first_error = reset($errors);
            $redirect_to = add_query_arg(array('error' => $first_error), $page_url);
            wp_safe_redirect($redirect_to);
            exit;
        }

        $fields = array(
            'dln_exchange_rate' => $dln_exchange_rate,
            'dln_chk_er' => $dln_chk_er,
        );

        // New or edit?
        if (!$field_id) {

            $insert_id = $this->save_settings($fields);

        } else {

            $fields['id'] = $field_id;

            $insert_id = $this->save_settings($fields);
        }

        if (is_wp_error($insert_id)) {
            $redirect_to = add_query_arg(array('message' => 'error'), $page_url);
        } else {
            $redirect_to = add_query_arg(array('message' => 'success'), $page_url);
        }

        wp_safe_redirect($redirect_to);
        exit;
    }

    /**
     * @return void
     */
    public function ndv_woo_setting_section_callback() {
        echo __( 'Thiết lập main cookie domain(SSO)', NDV_WOO );
    }

    /**
     * @return void
     */
    public function ndv_woo_setting_field_sso_domain() {
        $options = get_option( 'ndv_woo_settings' );
        ?>
        <input type='text' name='ndv_woo_settings[sso_domain]' value='<?php echo (isset($options['sso_domain']) ? $options['sso_domain'] : 'nhomdichvu.com'); ?>'>
        <?php
    }



    /**
     * @param $subscription
     */
    public function wcs_get_subscription( $subscription )
    {
        if ( ! $subscription ) {
            new WP_Error( 'test', 'test' );
        }

        return $subscription;
    }

    /**
     * Remove x quantity in checkout page.
     *
     * @param string $html
     * @param $cart_item
     * @param $cart_item_key
     * @return string
     */
    public function woocommerce_checkout_cart_item_quantity( $html = '', $cart_item, $cart_item_key )
    {
        return '';
    }

    /**
     * @param string $html
     * @param $item
     * @return string
     */
    public function woocommerce_order_item_quantity_html( $html = '', $item )
    {
        return '';
    }

    /**
     * @param $purchasable
     * @param $product
     */
    public function woocommerce_is_purchasable ( $purchasable, $product ) {
//        $subs     = wcs_get_users_subscriptions();
//        $sub_cats = array();
//        if ( count( $subs ) ) {
//            foreach ( $subs as $id => $sub ) {
//                if ( $sub->get_status() === 'active' ) {
//                    $items = $sub->get_items();
//                    if ( count( $items ) ) {
//                        foreach ( $items as $item ) {
//                            $cats = wp_get_post_terms( $item['product_id'], 'product_cat' );
//                            if ( count ( $cats ) ) {
//                                foreach ( $cats as $cat ) {
//                                    $sub_cats[] = $cat->term_id;
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }

        $check = false;
//        $terms = wp_get_post_terms( $product->id, 'product_cat' );
//        if ( count( $terms ) ) {
//            foreach ( $terms as $term ) {
//                if ( in_array( $term->term_id, $sub_cats ) ) {
//                    $check = true;
//                }
//            }
//        }

        return ( ! $check ) ? $purchasable : false;
    }

    /**
     * @param array $checkout_fields
     * @return array
     */
    public function woocommerce_checkout_fields( $checkout_fields = array() )
    {
        unset( $checkout_fields['billing']['billing_company'] );
        unset( $checkout_fields['billing']['billing_country'] );
        unset( $checkout_fields['billing']['billing_address_1'] );
        unset( $checkout_fields['billing']['billing_address_2'] );
        unset( $checkout_fields['billing']['billing_city'] );
        unset( $checkout_fields['billing']['billing_state'] );
        unset( $checkout_fields['billing']['billing_postcode'] );

        return $checkout_fields;
    }

    /**
     * Insert a new
     *
     * @param array $args
     */
    private function save_settings($args = array())
    {
        global $wpdb;

        $defaults = array(
            'id' => null,
            'dln_exchange_rate' => '',
            'dln_chk_er' => '',
        );

        $args = wp_parse_args($args, $defaults);
        $table_name = $wpdb->prefix . '';

        // some basic validation

        // remove row id to determine if new or update
        $row_id = (int)$args['id'];
        unset($args['id']);

        if (!$row_id) {

            // Insert a new
            if ($wpdb->insert($table_name, $args)) {
                return $wpdb->insert_id;
            }

        } else {

            // Do update method here
            if ($wpdb->update($table_name, $args, array('id' => $row_id))) {
                return $row_id;
            }
        }

        return false;
    }

}
