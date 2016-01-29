<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <link rel="icon" type="image/png" href="<?php cherry_file_uri( 'assets/img/favicons/favicon-16x16.png') ?>" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php cherry_file_uri( 'assets/img/favicons/favicon-32x32.png') ?>" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php cherry_file_uri( 'assets/img/favicons/favicon-96x96.png') ?>" sizes="96x96">
        <link rel="icon" type="image/png" href="<?php cherry_file_uri( 'assets/img/favicons/favicon-160x160.png') ?>" sizes="160x160">
        <link rel="icon" type="image/png" href="<?php cherry_file_uri( 'assets/img/favicons/favicon-192x192.png') ?>" sizes="192x192">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-57x57.png') ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-60x60.png') ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-72x72.png') ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-76x76.png') ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-114x114.png') ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-120x120.png') ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-144x144.png') ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-152x152.png') ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php cherry_file_uri( 'assets/img/favicons/apple-touch-icon-180x180.png') ?>">
        <?php wp_head(); ?>
    </head>
<body <?php cherry_attr( 'body' ); ?>>

<div id="page-container" class="header-navbar-fixed header-navbar-transparent header-navbar-scroll">
    <header id="header-navbar" class="content-mini content-mini-full">
        <div class="content-boxed">
            <ul class="js-nav-main-header nav-main-header pull-right">

                <li class="text-right hidden-md hidden-lg">
                    <button class="btn btn-link text-white" data-toggle="class-toggle" data-target=".js-nav-main-header" data-class="nav-main-header-o" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </li>

                <li class="">
                    <a class=" " href="http://nhomdichvu.localhost" >
                        Trang chủ
                    </a>
                </li>

            </ul>

            <ul class="nav-header pull-left">
                <li class="header-content">
                    <a class="h5" href="frontend_home.php">
                        <i class="fa fa-circle-o-notch text-primary"></i> <span class="h4 font-w600 text-white">ne</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>

<!--    -->
<!--    --><?php //do_action( 'cherry_body_start' ); ?>
<!---->
<!--    <div id="site-wrapper" class="hfeed site">-->
<!--        --><?php //do_action( 'cherry_header_before' ); ?>
<!---->
<!--        --><?php //do_action( 'cherry_header' ); ?>
<!---->
<!--        --><?php //do_action( 'cherry_header_after' ); ?>