<?php

define( 'NDV_SPL', 'ndv-spl' );
define( 'NDV_SPL_VER', '1.0.0' );

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 0, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', NDV_SPL ),
		'support'  => __( 'Support Menu', NDV_SPL ),
		'account' => __( 'Account Menu', NDV_SPL )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	add_theme_support( 'woocommerce' );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
//	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	$uri = get_template_directory_uri();
	wp_enqueue_style( NDV_SPL . '-bootstrap',    $uri . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css', array(), NDV_SPL_VER );
	wp_enqueue_style( NDV_SPL . '-font-awesome', $uri . '/assets/vendor/font-awesome/css/font-awesome.min.css', array(), NDV_SPL_VER );
	wp_enqueue_style( NDV_SPL . '-select2',      $uri . '/assets/vendor/select2/dist/css/select2.min.css', array(), NDV_SPL_VER );
	wp_enqueue_style( NDV_SPL . 'simple-icons',  $uri . '/assets/3rd-party/simple-line-icons/css/simple-line-icons.css', array(), NDV_SPL_VER );
	wp_enqueue_style( NDV_SPL . '-app',          $uri . '/assets/css/app.min.css', array(), NDV_SPL_VER );
	wp_enqueue_style( NDV_SPL . '-style',        $uri . '/assets/css/style.css', array(), NDV_SPL_VER );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20150825' );
	}

//	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150825', true );

	wp_enqueue_script( NDV_SPL . 'bootstrap',         $uri . '/assets/vendor/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), NDV_SPL_VER, true );
	wp_enqueue_script( NDV_SPL . 'jquery-scrollLock', $uri . '/assets/vendor/jquery-scrollLock/jquery-scrollLock.min.js', array( 'jquery' ), NDV_SPL_VER, true );
	wp_enqueue_script( NDV_SPL . 'jquery_appear',     $uri . '/assets/vendor/jquery_appear/jquery.appear.js', array( 'jquery' ), NDV_SPL_VER, true );
	wp_enqueue_script( NDV_SPL . 'select2',           $uri . '/assets/vendor/select2/dist/js/select2.min.js', array( 'jquery' ), NDV_SPL_VER, true );
	wp_enqueue_script( NDV_SPL . 'app',               $uri . '/assets/js/app.js', array( 'jquery' ), NDV_SPL_VER, true );
	wp_enqueue_script( NDV_SPL . 'dlt-custom',        $uri . '/assets/js/dlt-custom.js', array( 'jquery' ), NDV_SPL_VER, true );

//	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
//		'expand'   => __( 'expand child menu', 'twentysixteen' ),
//		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
//	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function ndv_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'ndv_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

add_action( 'woocommerce_register_form', 'dln_extra_register_fields' );
/**
 *
 */
function dln_extra_register_fields()
{
	?>
	<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php _e( 'Số điện thoại', NDV_SPL ); ?> <span class="required">*</span></label>
		<input type="text" class="input-text" name="phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['phone'] ) ) esc_attr_e( $_POST['phone'] ); ?>" />
	</p>
	<?php
}

add_action( 'woocommerce_register_post', 'dln_validate_extra_register_fields', 99, 3 );
/**
 * @param $username
 * @param $email
 * @param $validation_errors
 */
function dln_validate_extra_register_fields( $username, $email, $validation_errors )
{
	if ( isset( $_POST['phone'] ) && empty( $_POST['phone'] ) ) {
		$validation_errors->add( 'phone_error', __( 'Vui lòng nhập số điện thoại!', NDV_SPL ) );
	}
}

add_action( 'woocommerce_created_customer', 'dln_save_extra_register_fields' );
/**
 * @param $customer_id
 */
function dln_save_extra_register_fields( $customer_id )
{
	if ( isset( $_POST['phone'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'phone', sanitize_text_field( $_POST['phone'] ) );
	}
}

add_action( 'widgets_init', 'dln_widgets_init' );
/**
 * @return void
 */
function dln_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Account', NDV_SPL ),
		'id'            => 'account',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<div id="%1$s" class="block block-rounded %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="block-header bg-gray-lighter text-center">',
		'after_title'   => '</div>',
	) );
}

/**
 * @param array $args
 * @return array
 */
function dln_woocommerce_breadcrumb_defaults( $args = array() ) {
	$args['wrap_before'] = '<ol class="breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';
	$args['wrap_after']  = '</ol>';
	$args['delimiter']   = '';

	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'dln_woocommerce_breadcrumb_defaults', 10, 1 );

/**
 * @param $items
 * @param $args
 * @return mixed
 */
function dln_wp_nav_menu_breadcrumb_items( $items, $args ) {
	$html = <<<HTML
<li class="text-right hidden-md hidden-lg">
	<button class="btn btn-link text-white" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
		<i class="fa fa-times"></i>
	</button>
</li>
HTML;

	return $html . $items;
}
add_filter( 'wp_nav_menu_breadcrumb_items', 'dln_wp_nav_menu_breadcrumb_items', 10, 2 );

/**
 * Set class active for menu selected question list
 * @param  string $current_url 
 * @return boolean              
 */
function dlt_set_active_class_question($current_url = '') {
	if ( empty($current_url) ) {
		return false;
	}

	$url_questions = home_url( 'questions' );
	$url_add_question = home_url( 'add-question' );
	$url_question = home_url( 'question' );

	if ( substr_count($current_url, $url_questions) || substr_count($current_url, $url_add_question) || substr_count($current_url, $url_question) ) {
		return true;
	} else {
		return false;
	}
}
