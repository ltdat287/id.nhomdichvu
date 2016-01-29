<?php

//require_once ABSPATH . '/wp-content/plugins/rest-api/lib/endpoints/class-wp-rest-controller.php';
require_once ABSPATH . '/wp-content/plugins/ndv-woocommerce-gateway/vendor/autoload.php';
use \Firebase\JWT\JWT;

//class JWTAuth extends WP_REST_Controller
class JWTAuth
{
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
        $this->load_dependencies();
        $this->add_cors_support();
        $this->add_endpoints();

        add_action( 'wp_login', array( $this, 'create_cookie_after_login' ), 10, 2 );
        add_action( 'wp_logout', array( $this, 'remove_cookie_after_logout' ) );
        add_action( 'init', array( $this, 'check_exists_token' ) );
        add_action( 'woocommerce_subscription_status_updated', array( $this, 'woocommerce_subscription_status_updated' ), 10, 3 );
    }

    /**
     * @return void
     */
    private function load_dependencies()
    {

    }

    /**
     * @param $user_login
     * @param $user
     * @return mixed
     */
    public function create_cookie_after_login( $user_login, $user )
    {
        if ( ! isset( $user->ID ) ) {
            return false;
        }

        $data = self::get_jwt_token( $user );

        if ( isset( $data['token'] ) ) {
            self::setToken($data['token']);
        }

        return $data;
    }

    /**
     * @param string $token
     * @return bool
     */
    public static function setToken($token = '')
    {
        if (! $token) {
            return false;
        }

        setcookie( 'dln_token', $token, 0, COOKIEPATH, self::get_domain() );
    }

    /**
     * @return void
     */
    public function check_exists_token()
    {
        $user = wp_get_current_user();

        if ( ! $user->ID ) {
            wp_logout();

            return false;
        }

        $token = '';
        $pod   = pods( 'jwt_user_token' );

        if ($pod) {
            $record = $pod->find( null, 1, "author.ID = {$user->ID}" );
            $data   = $record->fetch();
            if ($data) {
                $token = isset($data['token']) ? $data['token'] : '';
            } else {
                $data = self::get_jwt_token($user);
                $token = isset($data['token']) ? $data['token'] : '';
            }
        }

        $current_token = isset( $_COOKIE['dln_token'] ) ? $_COOKIE['dln_token'] : '';

        if ( ! $current_token || $current_token != $token ) {
            self::setToken($token);
        }

        return true;
    }

    /**
     * @return void
     */
    public function remove_cookie_after_logout()
    {
        setcookie( 'dln_token', '', 0, COOKIEPATH, self::get_domain() );
    }

    /**
     * @return string
     */
    private static function get_domain()
    {
        $options = get_option( 'ndv_woo_settings' );

        return isset( $options['sso_domain'] ) ? $options['sso_domain'] : 'nhomdichvu.com';
    }

    /**
     * @return void
     */
    public function add_endpoints()
    {
        add_action('rest_api_init', function () {
            register_rest_route('wp/v2', '/login', array(
                'methods'         => WP_REST_Server::READABLE,
                'callback'        => array( $this, 'rest_api_login' )
            ));
        });
    }

    /**
     * @return void
     */
    public function rest_api_login( $request )
    {
        $user = self::get_current_user(true);

        if ( empty( $user ) ) {
            return new WP_Error( 'rest_type_invalid', __( 'Invalid.' ), array( 'status' => 404 ) );
        }

        $response = rest_ensure_response( $user );

        return $response;
    }

    /**
     * Add CORS suppot to the request.
     */
    public function add_cors_support()
    {
        $enable_cors = defined('JWT_AUTH_CORS_ENABLE') ? JWT_AUTH_CORS_ENABLE : false;
        if ($enable_cors) {
            $headers = apply_filters('jwt_auth_cors_allow_origin', '*');
            header(sprintf('Access-Control-Allow-Origin: %s', $headers));
        }
    }

    /**
     * @param $sub
     * @param $old_status
     * @param $new_status
     * @return bool
     */
    public function woocommerce_subscription_status_updated( $sub, $old_status, $new_status )
    {
        $sub  = wcs_get_subscription( $sub );
        $user = $sub->get_user();
        if ( ! $user->ID ) {
            return false;
        }

        self::get_jwt_token( $user );
    }

    /**
     * @param array $user
     * @return array
     */
    public static function get_jwt_token($user = array())
    {
        $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
        /** Valid credentials, the user exists create the according Token */
        $createdAt  = time();
        $notBefore = apply_filters('jwt_auth_not_before', $createdAt, $createdAt);
        $expire    = apply_filters('jwt_auth_expire', $createdAt + (DAY_IN_SECONDS * 7), $createdAt);

        if ( ! $user->ID ) {
            return false;
        }

        $data = array(
            'iss' => get_bloginfo('url'),
            'crt' => $createdAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'user' => array(
                'id'       => $user->data->ID,
                'email'    => $user->data->user_email,
                'name'     => $user->data->display_name,
                'nicename' => $user->data->user_nicename,
                'avatar'   => '',
                'fb_id'    => get_user_meta($user->ID, 'fb_id')
            ),
        );

        /** Let the user modify the token data before the sign. */
        $data = apply_filters( 'jwt_auth_token_before_sign', $data );
        $token = JWT::encode( $data, $secret_key );

        // Save token into DB.
        self::save_token( $token, $user->ID );

        /** The token is signed, now create the object with no sensible user data to the client*/
        $data = array_merge( $data, array( 'token' => $token ) );

        return $data;
    }

    /**
     * @param bool|true $output
     * @return array|object|WP_Error
     */
    public static function get_current_user($output = true)
    {
        /*
         * Looking for the HTTP_AUTHORIZATION header, if not present just
         * return the user.
         */
        $auth = isset($_SERVER['HTTP_AUTHORIZATION']) ?  $_SERVER['HTTP_AUTHORIZATION'] : false;
        if (!$auth) {
            return new WP_Error(
                'jwt_auth_no_auth_header',
                __('Authorization header not found.', NDV_WOO),
                array(
                    'status' => 403,
                )
            );
        }

        /*
         * The HTTP_AUTHORIZATION is present verify the format
         * if the format is wrong return the user.
         */
        list($token) = sscanf($auth, 'Bearer %s');
        if (! $token) {
            return new WP_Error(
                'jwt_auth_bad_auth_header',
                __('Authorization header malformed.', NDV_WOO),
                array(
                    'status' => 403,
                )
            );
        }

        if (! $token && isset( $_GET['token'] )) {
            $token = $_GET['token'];
        }

        /** Get the Secret Key */
        $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
        if (!$secret_key) {
            return new WP_Error(
                'jwt_auth_bad_config',
                __('JWT is not configurated properly, please contact the admin', NDV_WOO),
                array(
                    'status' => 403,
                )
            );
        }

        /** Try to decode the token */
        try {
            $token = JWT::decode($token, $secret_key, array('HS256'));
            /** The Token is decoded now validate the iss */
            if ($token->iss != get_bloginfo('url')) {
                /** The iss do not match, return error */
                return new WP_Error(
                    'jwt_auth_bad_iss',
                    __('The iss do not match with this server', NDV_WOO),
                    array(
                        'status' => 403,
                    )
                );
            }
            /** So far so good, validate the user id in the token */
            if (!isset($token->data->user->id)) {
                /** No user id in the token, abort!! */
                return new WP_Error(
                    'jwt_auth_bad_request',
                    __('User ID not found in the token', NDV_WOO),
                    array(
                        'status' => 403,
                    )
                );
            }
            /** Everything looks good return the decoded token if the $output is false */
            if (!$output) {
                return $token;
            }
            /** If the output is true return an answer to the request to show it */
            return array(
                'code' => 'jwt_auth_valid_token',
                'data' => array(
                    'status' => 200,
                ),
            );
        } catch (Exception $e) {
            /** Something is wrong trying to decode the token, send back the error */
            return new WP_Error(
                'jwt_auth_invalid_token',
                $e->getMessage(),
                array(
                    'status' => 403,
                )
            );
        }
    }

    /**
     * @param string $token
     * @param int $user_id
     * @return bool
     */
    public static function save_token( $token = '', $user_id = 0 )
    {
        if ( ! $token || ! $user_id ) {
            return false;
        }

        $md5    = md5( $token );
        $pod    = pods( 'jwt_user_token' );
        if ($pod) {
            $record = $pod->find( null, 1, "author.ID = {$user_id}" );
        }

        // Save new token if not exists.
        if ( ! $record->fetch() ) {
            $record = $pod->save( array(
                'md5'    => $md5,
                'token'  => $token,
                'author' => $user_id
            ) );
        } else {
            $record->save( array(
                'token' => $token,
                'md5'   => $md5
            ) );
        }
    }

    /**
     * @param int $user_id
     * @return bool
     */
    public static function remove_token( $user_id = 0 )
    {
        if ( ! $user_id ) {
            return false;
        }

        $pod    = pods( 'jwt_user_token' );
        $records = $pod->find( null, -1, "author.ID = {$user_id}" );

        while( $records->fetch() ) {
            $records->delete();
        }
    }

}

$instance = new JWTAuth();