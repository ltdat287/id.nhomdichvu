<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://nhomdichvu.com
 * @since      1.0.0
 *
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ndv_Woocommerce_Gateway
 * @subpackage Ndv_Woocommerce_Gateway/includes
 * @author     DinhLN <lenhatdinh@gmail.com>
 */
class Ndv_Woocommerce_Gateway
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Ndv_Woocommerce_Gateway_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->plugin_name = 'ndv-woocommerce-gateway';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        add_action( 'ndv_auto_handle_order',          array( $this, 'ndv_auto_handle_order' ) );
        add_action( 'ndv_auto_handle_subscription',   array( $this, 'ndv_auto_handle_subscription' ) );
        add_filter( 'cron_schedules',                 array( $this, 'add_wp_cron_schedule' ) );
        add_filter( 'woocommerce_product_is_visible', array( $this, 'woocommerce_product_is_visible' ), 10, 2 );
        add_shortcode( 'ndv_woo_page',                array( $this, 'shortcode_ndv_woo_page' ) );
        add_shortcode( 'ndv_list_subs',               array( $this, 'shortcode_ndv_list_subs' ) );
        add_filter( 'jwt_auth_token_before_sign',     array( $this, 'jwt_auth_token_before_sign' ) );
        add_filter( 'woocommerce_checkout_fields' ,   array( $this, 'alter_woocommerce_checkout_fields' ) );
        add_action( 'woocommerce_order_items_meta_get_formatted', array( $this, 'woocommerce_order_items_meta_get_formatted' ), 99, 2 );
        add_filter( 'woocommerce_get_item_data',      array( $this, 'woocommerce_get_item_data' ), 99, 2 );
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Ndv_Woocommerce_Gateway_Loader. Orchestrates the hooks of the plugin.
     * - Ndv_Woocommerce_Gateway_i18n. Defines internationalization functionality.
     * - Ndv_Woocommerce_Gateway_Admin. Defines all hooks for the admin area.
     * - Ndv_Woocommerce_Gateway_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ndv-woocommerce-gateway-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ndv-woocommerce-gateway-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ndv-woocommerce-gateway-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-ndv-woocommerce-gateway-public.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-jwt-auth.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-gateway-chuyenkhoan.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-ndv-share.php';

        $this->loader = new Ndv_Woocommerce_Gateway_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Ndv_Woocommerce_Gateway_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Ndv_Woocommerce_Gateway_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Ndv_Woocommerce_Gateway_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'ndv_woo_gateway_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'admin_init');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Ndv_Woocommerce_Gateway_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Ndv_Woocommerce_Gateway_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * @return void
     */
    public function ndv_auto_handle_order()
    {
        // Get order pending.
        $posts = get_posts( array(
            'post_status'    => 'wc-processing',
            'post_type'      => 'shop_order',
            'posts_per_page' => 50,
        ) );

        if ( count( $posts ) ) {
            foreach ( $posts as $post ) {
                $order = wc_get_order( $post );
                if ( $order->get_total() == 0 ) {
                    $order->update_status( 'completed', __( 'Tự động completed', NDV_WOO )  );
                }
            }
        }

        dd($posts);
    }

    /**
     * @return bool
     */
    public function ndv_auto_handle_subscription()
    {
        // Get order pending.
        $records = wcs_get_subscriptions( array(
            'subscription_status'    => 'pending-cancel',
            'subscriptions_per_page' => 100,
            'orderby'                => 'order_total',
            'order'                  => 'ASC'
        ) );

        if ( count( $records ) ) {
            foreach ( $records as $sub ) {
                if ( $sub->get_total() == 0 ) {
                    $this->remove_sub( $sub );
                }
            }
        }

        $records = wcs_get_subscriptions(array(
            'subscription_status'    => 'cancelled',
            'subscriptions_per_page' => 100,
            'orderby'                => 'order_total',
            'order'                  => 'ASC'
        ));

        if ( count( $records ) ) {
            foreach ( $records as $sub ) {
                if ( $sub->get_total() == 0 ) {
                    $this->remove_sub( $sub );
                }
            }
        }

        $records = wcs_get_subscriptions(array(
            'subscription_status'    => 'on-hold',
            'subscriptions_per_page' => 100,
            'orderby'                => 'order_total',
            'order'                  => 'ASC'
        ));

        if ( count( $records ) ) {
            foreach ( $records as $sub ) {
                if ( $sub->get_total() == 0 ) {
                    $this->remove_sub( $sub );
                }
            }
        }

        dd($records);
    }

    /**
     * @param $sub
     * @return bool
     */
    private function remove_sub( $sub )
    {
        if ( ! $sub ) {
            return false;
        }

        // Remove order.
        $order_id = $sub->post->post_parent;

        if ( $order_id ) {
            wp_delete_post( $order_id );
        }

        $sub->remove_order_items();
        wp_delete_post( $sub->id, true );
    }

    /**
     * @param $schedules
     * @return mixed
     */
    public function add_wp_cron_schedule( $schedules ) {
        $schedules['every_15_minute'] = array(
            'interval' => 60 * 15, // in seconds
            'display'  => __( 'Every 15 minute' ),
        );

        $schedules['every_30_minute'] = array(
            'interval' => 60 * 30, // in seconds
            'display'  => __( 'Every 30 minute' ),
        );

        return $schedules;
    }

    /**
     * @param array $atts
     * @return html
     */
    public function shortcode_ndv_woo_page( $atts = array() )
    {
        if ( isset( $atts[ 'view' ] ) ) {
            wc_get_template( $atts[ 'view' ], $atts );
        }
    }

    /**
     * @return void
     */
    public function shortcode_ndv_list_subs()
    {
        return WC_Subscriptions::get_my_subscriptions_template();
    }

    /**
     * @param $visible
     * @param $product_id
     */
    public function woocommerce_product_is_visible( $visible, $product_id )
    {
        $visible = false;

        return $visible;
    }

    /**
     * @param $fields
     * @return mixed
     */
    public function alter_woocommerce_checkout_fields( $fields ) {
        unset($fields['order']['order_comments']);
        return $fields;
    }

    /**
     * @param array $data
     * @return void
     */
    public function jwt_auth_token_before_sign( $data = array() )
    {
        $subs = wcs_get_users_subscriptions();

        $sub_data = array();
        if ( count( $subs ) ) {
            foreach ( $subs as $sub ) {
                $sub = wcs_get_subscription( $sub );

                $order = wc_get_order( $sub->order );
                if ( $sub->get_status() === 'active' ) {
                    if ( count( $sub->get_items() ) ) {
                        foreach ( $sub->get_items() as $item ) {
                            $variation_id = ( isset( $item['variation_id'] ) ) ? $item['variation_id'] : '';
                            $attrs   = wc_get_product_variation_attributes( $variation_id );

                            if ( count( $attrs ) ) {
                                foreach ( $attrs as $name => $value ) {
                                    $term = get_term_by('slug', $value, str_replace( 'attribute_', '', $name ));
                                    $name = str_replace( '-', '_', $name );
                                    $name = str_replace( 'attribute_pa_', '', $name );

                                    $sub_data[ $name ] = $term->name;
                                }
                            }

                            $end_date = $sub->get_time( 'next_payment' );
//                            $end_date = date('Y-m-d', $end_date);
                            $sub_data['end_date'] = ( isset( $sub_data['end_date'] ) && $end_date <= $sub_data['end_date'] ) ? $sub_data['end_date'] : $end_date;
                        }
                    }
                }
            }
        }

        $data['user'] = array_merge( $data['user'], $sub_data );

        return $data;
    }

    /**
     * @param $formatted_meta
     * @param $this
     */
    public function woocommerce_order_items_meta_get_formatted( $formatted_meta, $item )
    {
        $product = $item->product;
        if ( $product ) {
            $formatted_meta = $this->get_item_datas( $product, $formatted_meta );
        }

        return $formatted_meta;
    }

    /**
     * @param $item_data
     * @param $cart_item
     * @return array
     */
    public function woocommerce_get_item_data( $item_data, $cart_item )
    {
        $product = $cart_item['data'];
        if ( $product ) {
            $item_data = $this->get_item_datas( $product, $item_data );
        }

        return $item_data;
    }

    /**
     * @param $product
     * @param array $item_data
     * @return array
     */
    private function get_item_datas( $product, $item_data = array() )
    {
        $attrs   = $product->get_attributes();

        $variations = array();
        if ( ! empty( $product->variation_id ) ) {
            $variations = wc_get_product_variation_attributes( $product->variation_id );
        }

        if ( count( $attrs ) ) {
            foreach ( $attrs as $name => $attribute ) {
                $label  = wc_attribute_label( $attribute['name'] );
                if ( count( $variations ) ) {
                    $term = get_term_by('slug', $variations['attribute_' . $name], $name);

                    $item_data[] = array(
                        'key'   => $label,
                        'label' => $label,
                        'value' => wpautop( wptexturize( $term->name ) )
                    );
                } else {
                    $values = wc_get_product_terms( $product->id, $attribute['name'] );
                    $item_data[] = array(
                        'key'   => $label,
                        'label' => $label,
                        'value' => wpautop( wptexturize( implode( ', ', $values ) ) )
                    );
                }
            }
        }

        return $item_data;
    }

}
