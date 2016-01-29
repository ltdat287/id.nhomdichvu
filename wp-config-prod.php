<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/dinhln/domains/nhomdichvu.com/public_html/id/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'dinhln_id');

/** MySQL database username */
define('DB_USER', 'dinhln_id');

/** MySQL database password */
define('DB_PASSWORD', 'admin1989');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(vw<`Wa#~FFAVSZI%S>-Ky-X*]E$nGgYV,Fyh|smRW[59&44kT[ DZJC|UtY(I|P');
define('SECURE_AUTH_KEY',  '@3x}+/2{8TIPLdsV1$0GSeUSmz-d95W|Ior_s0T8f;_(gK~?/44!N PxFAG`J*{9');
define('LOGGED_IN_KEY',    'yBAQEpCI(H8KV%Yd9x-#{Tk&>r-@-*6d^/(+W-t,Ia#xM:A/[S(@#9Ny/rk.K`!A');
define('NONCE_KEY',        'GbNcdq_/OaECenm.`^-MtOQ{b2;3]8O|%d|N]hBv+LAU+!8VSwh}S6Rt}`H-q)Wk');
define('AUTH_SALT',        '6SKsP-nvP/!-^|jTXrDYH@PRzV|Bh@nB}zNOci5YLd28s1Ep<q]Nh6Z;q4rtO/PF');
define('SECURE_AUTH_SALT', 'rnlry }JTE0rP7f#~QL~8=!Z:N-/,TEqRs+X&ncXS2T;m0-v^[Yzk@gi<}2xO+%L');
define('LOGGED_IN_SALT',   'NXF|-96CJfn4!1pvS<o899[7x?1OQju~3maQ|l?=Kt[3P{+6p4GJeuPf&pnDp}^d');
define('NONCE_SALT',       'JPLq^4;C+Vdw[_##po0!ezrNGZk{?pht}Hd+(3~D7RXx,DI|yG_P+zds!uh<>e[-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' );
define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
