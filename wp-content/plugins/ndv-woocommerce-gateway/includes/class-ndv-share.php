<?php

class NDV_Share
{
    /**
     * @return void
     */
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts',                               array( $this, 'frontend_scripts' ) );
        add_action( 'wp_ajax_ndv_active_free_order',                    array( $this, 'active_free_order' ) );
        add_action( 'wp_ajax_nopriv_ndv_active_free_order',             array( $this, 'active_free_order' ) );
    }

    /**
     * @return void
     */
    public function frontend_scripts()
    {
        global $post;

        $message = get_option( 'ndv_setting_message' );
        $url     = get_option( 'ndv_setting_url' );

        $params = array(
            'ajax_social_url'    => add_query_arg( 'action', 'ndv_active_free_order', str_replace( array( 'https:', 'http:' ), '', admin_url( 'admin-ajax.php' ) ) ),
            'apply_coupon_nonce' => wp_create_nonce( 'active-free-order' ),
            'sharing'            => array(
                'url'              => apply_filters( 'ndv_share_post_url', isset( $url ) ? $url : get_permalink( $post->ID ) ),
                'message'          => apply_filters( 'ndv_share_post_message', isset( $message ) ? $message : get_the_title( $post->ID ) ),
                'twitter_username' => get_option( 'ndv_setting_twitter_username' ),
            ),
            'locale'             => get_locale(),
            'facebook'           => 'no',
            'twitter'            => 'no',
            'google'             => 'no'
        );

        if ( get_option( 'ndv_setting_facebook_app_id' ) ) {

            $params['facebook']  = 'yes';
            $params['fb_app_id'] = get_option( 'ndv_setting_facebook_app_id' );

        }

        if ( get_option( 'ndv_setting_twitter_username' ) ) {

            $params['twitter'] = 'yes';

        }

        if ( get_option( 'ndv_setting_enable_google' ) ) {

            $params['google'] = 'yes';

        }

        wp_enqueue_script( 'ndv-share', NDV_WOO_URL . 'public/js/ndv-share.js', array( 'jquery' ), NDV_WOO_VER, false );
        wp_localize_script( 'ndv-share', 'ndv_share', apply_filters( 'ndv_share_scripts_filter', $params ) );
    }

    /**
     * @return void
     */
    public function active_free_order()
    {
        try {
            $response  = array();

            $fb_id        = isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
            $redirect_url = isset( $_POST['redirect_url'] ) ? $_POST['redirect_url'] : '';

            if ( ! $fb_id || ! $redirect_url || ! is_user_logged_in() ) {
                throw new Exception( __( 'Không thể kích hoạt', NDV_WOO ) );

                return false;
            }

            $user = wp_get_current_user();
            update_user_meta( $user->ID, 'ndv_share', $fb_id );

            $response['status']   = 'success';
            $response['redirect'] = $redirect_url;

            if ( is_ajax() ) {
                echo '<!--WC_START-->' . json_encode( $response ) . '<!--WC_END-->';
                exit;
            }
            else {
                wp_redirect( $response['redirect'] );
                exit;
            }

        } catch ( Exception $e ) {

            if ( !empty( $e ) ) {
                wc_add_notice( $e->getMessage(), 'error' );
            }

        }

        if ( is_ajax() ) {

            ob_start();
            wc_print_notices();
            $messages = ob_get_clean();

            echo '<!--WC_START-->' . json_encode(
                    array(
                        'result'   => 'failure',
                        'messages' => isset( $messages ) ? $messages : ''
                    )
                ) . '<!--WC_END-->';

            exit;

        }
    }

    /**
     * @return bool|mixed
     */
    public static function check_shared()
    {
        if ( ! is_user_logged_in() ) {
            return false;
        }

        $user = wp_get_current_user();
        $shared = get_user_meta( $user->ID, 'ndv_share', true );

        return $shared;
    }

    /**
     * @return bool
     */
    public static function ndv_render_share()
    {
        $shared = self::check_shared();
        if ( $shared ) {
            return false;
        }

        $message = get_option( 'ndv_setting_message' );
        $url     = get_option( 'ndv_setting_url' );

        $social_params = apply_filters( 'ndv_share_social_params', array(
            'sharing'            => array(
                'url'              => apply_filters( 'ndv_share_post_url', isset( $url ) ? $url : get_permalink( $post->ID ) ),
                'message'          => apply_filters( 'ndv_share_post_message', isset( $message ) ? $message : get_the_title( $post->ID ) ),
                'twitter_username' => get_option( 'ndv_setting_twitter_username', '' ),
            ),
            'facebook'      => get_option( 'ndv_setting_facebook_app_id' ),
            'facebook_type' => get_option( 'ndv_setting_facebook_button_type' ),
            'twitter'       => get_option( 'ndv_setting_twitter_username' ),
            'google'        => get_option( 'ndv_setting_google_enable' ),
            'google_type'   => get_option( 'ndv_setting_google_button_type' ),
        ) );

        include( dirname(__FILE__) . '/template-ndv-share-buttons.php' );
    }
}

$share = new NDV_Share();