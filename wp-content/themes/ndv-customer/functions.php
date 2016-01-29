<?php
/**
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 */

// Load the Cherry Framework.
require_once( trailingslashit( get_template_directory() ) . 'lib/class-cherry-framework.php' );
new Cherry_Framework();

// Sets up theme defaults and registers support for various WordPress features.
add_action( 'after_setup_theme', 'cherry_theme_setup' );
function cherry_theme_setup() {

	// Load the initialization file.
	require_once( trailingslashit( PARENT_DIR ) . 'init/init.php' );

	// Load necessary config parts.
	cherry_theme_config();
}

add_filter( 'cherry_get_styles', 'dln_cherry_get_styles' );
function dln_cherry_get_styles( $styles ) {

	// Get the theme prefix.
	$prefix = cherry_get_prefix();

	// Get the active theme stylesheet version.
	$version = wp_get_theme()->get( 'Version' );

	$styles['toast'] = array(
		'handle'  => $prefix . 'app',
		'src'     => cherry_file_uri( 'assets/css/app.min.css' ),
		'version' => $version
	);

	$styles['app'] = array(
		'handle'  => $prefix . 'app',
		'src'     => cherry_file_uri( 'assets/css/app.min.css' ),
		'version' => $version
	);

	return $styles;

}

add_filter( 'cherry_get_footer_class', 'dln_cherry_get_footer_class' );
function dln_cherry_get_footer_class( $class )
{
	return $class . ' content-mini content-mini-full font-s12 bg-gray-lighter';
}