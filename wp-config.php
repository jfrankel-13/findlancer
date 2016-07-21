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
define('DB_NAME', 'local.findlancer.com');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '-${aL..GSS>MF3V(tj>h#FV%m1o) Gk&A#1ky(_I;+I9@S2iFAz1-<N0r)?iM25V');
define('SECURE_AUTH_KEY',  '}w!#D?&QF)4rkU:ph8j_xm3hh(B#el}QCH9eRhhJ`]4?:i8wM@+^I0$/$/;!_+VC');
define('LOGGED_IN_KEY',    '_8&sV{_{rPEPL^u59;|cK`$1@_]poaNP1vGY9P?Q_8VD+hMf/R7^GSKjY-ECpGUH');
define('NONCE_KEY',        'xm=Ex+_tcb`MW-B@v+3|8c4.VAuJA 6v*!Cf*XfZXb-:|VEje*S$~f-^I#/U>?HC');
define('AUTH_SALT',        '@NzxxEaK4lB_:j88W?lg.r#=`(pp>D wM.c#N#n6HTYQsu;p|5G-)B3n:;Pj0+RA');
define('SECURE_AUTH_SALT', 'O.Fy^;6oC2O6V}2poOfrQ*QIKv@Pcgzz?c`CCK}HgHfo2=#w~MkVC.E[zvD@bYS[');
define('LOGGED_IN_SALT',   'n{*&q}><kj#83:uBP)pEUOYX7_*>r*~[ip/Ggi.+toRf;}5e7KinxL[AEZC$6]Nx');
define('NONCE_SALT',       ']B( UMD!mCea$LXZ_I;&BEA|KJ5mc2wPM5:3em=baRGjHPclPKWn(p<<3Kh^tBLU');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
