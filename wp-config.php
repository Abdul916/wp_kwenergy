<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_kwenergy' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-r%cIW[S9}c/RpTWHS8h}/Mt dlNjI#UF>#^bqc4SL>~>ygSE0V/xMXyx*cRn]vG' );
define( 'SECURE_AUTH_KEY',  '*`y?G`>>;sxhnL+v`yXDu6r<[J%cB/5DbeeK=vrpiAO}c!C)0O)@Y]KutZg7Yl9v' );
define( 'LOGGED_IN_KEY',    '{8L^RJ7/x1Kp#)18.gyCLQZy1QY&PYJ&%FA7*eN|6#>AA:QF_dKg1!~;r6X=5%YE' );
define( 'NONCE_KEY',        'd/VR!6<*jDhOrPR]B|rJj-aW|Q<B$?V-pkv^BxUUsWjd^=G2-HRH5:f =4^ z0Rw' );
define( 'AUTH_SALT',        'VYy LcD.i(R80GLTdOkQ-6k8zx}EFL&A,w]`%Lkx1zZ!tp$J~~[:{()r4h3g88I6' );
define( 'SECURE_AUTH_SALT', 'G3H,hFJSg]UzM;_*I=GZ6Mf(ov9|QCur[IZX&lX9`psl!FS,!1)27|?Lh1qInsb!' );
define( 'LOGGED_IN_SALT',   '-htMw ~BFHO5RiCa;=S~|_~k|K&5gEMJg55Sh4.>Qul2WnnyUV(jJ7#?G-#HUF)B' );
define( 'NONCE_SALT',       'Oj2hCbv$Go4d%dh`.QHA=9)]]MPR6D>UF}6d[1RQ+jKsGBM#lF3|^sEn<([<V8xE' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
