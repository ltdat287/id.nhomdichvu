<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

	$uri = get_template_directory_uri();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
	<link rel="shortcut icon" href="assets/img/favicons/favicon.png">
	<link rel="icon" type="image/png" href="<?php echo $uri ?>/assets/img/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="<?php echo $uri ?>/assets/img/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php echo $uri ?>/assets/img/favicons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="<?php echo $uri ?>/assets/img/favicons/favicon-160x160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="<?php echo $uri ?>/assets/img/favicons/favicon-192x192.png" sizes="192x192">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $uri ?>/assets/img/favicons/apple-touch-icon-180x180.png">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page-container" class="header-navbar-fixed header-navbar-transparent header-navbar-scroll">

	<header id="header-navbar" class="content-mini content-mini-full">
		<div class="content-boxed">

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<ul class="nav-header pull-right">
					<li class="hidden-md hidden-lg">
						<button class="btn btn-link text-white pull-right" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
							<i class="fa fa-navicon"></i>
						</button>
					</li>
				</ul>
				<?php
				wp_nav_menu( array(
					'container' => '',
					'theme_location' => 'primary',
					'menu_class'     => 'js-nav-main-header nav-main-header pull-right',
				) );
				?>
			<?php endif; ?>

			<ul class="nav-header pull-left">
				<li class="header-content">
					<a class="h5 text-white" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<i class="fa fa-dot-circle-o text-success"></i> <span class="h5 font-w600 sidebar-mini-hide">nhomdichvu.com</span>
					</a>
				</li>
			</ul>
		</div>
	</header>
