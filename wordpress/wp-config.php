<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'data_wordpress' );

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
define( 'AUTH_KEY',         'HH2D!L]%{aqaJvfI6iUYf~9@nnAjsA[`@4x_jjSvZtHM2/$,T@nXN1K.LWo~2;>M' );
define( 'SECURE_AUTH_KEY',  'NRd3n]$Q~<gVKb}nZ@MG>? g}i2bc|PtS-e+FEZ@^.Y:|@e{~ISPyq*~>/?`ZZ,e' );
define( 'LOGGED_IN_KEY',    '-?rAWGqHF^#]]aPTGbH3V0r@)9H;S^~[+B`JJ:}#kuOE#hVNe>L`^a`b{c1sN+ZZ' );
define( 'NONCE_KEY',        'D!4I%YS+ s|!SH|}&YQ?cqWCq@h[ $6`wkO.V30/Mx;(p[g1Dz+d(}YN.|2wY[RG' );
define( 'AUTH_SALT',        '&&xZ37?ZKlw;i;_s{J9Ifv?YEz)o9#2ma`[6)i:#0nOYsk+=<eWhuM~-=QL,&G}T' );
define( 'SECURE_AUTH_SALT', 'r(n[%E<wHE+M~$/-*dKLMG)^eH-4ZJIx.%lyA7CXi=}a,}3&cFSTEhD`w]&ye4mI' );
define( 'LOGGED_IN_SALT',   '$(d&^aq-r)/KodOoT<OW&0.q78GH~S};@A0lG`+GjH<wccs>/A2U_O-mpEIl7!E,' );
define( 'NONCE_SALT',       'pE7^:@b}}949J|d{V>7:hQ@Z24y|LCzCkJS=L,K^zL(xB<ubweLmb9G!vFu?L>B-' );

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
