<?php

// Configuration common to all environments
// include_once __DIR__ . '/wp-config.common.php';

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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'localdb');
define( 'DB_USER', 'user');
define( 'DB_PASSWORD', 'pass');
define( 'DB_HOST', 'db');
define( 'DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');

define( 'WP_HOME', 'https://localhost' );
define( 'WP_SITEURL', 'https://localhost' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'YourAuthKey');
define( 'SECURE_AUTH_KEY',  'YourSecureAuthKey');
define( 'LOGGED_IN_KEY',    'YourLoggedInKey');
define( 'NONCE_KEY',        'YourNonceKey');
define( 'AUTH_SALT',        'YourAuthSalt');
define( 'SECURE_AUTH_SALT', 'YourSecureAuthSalt');
define( 'LOGGED_IN_SALT',   'YourLoggedInSalt');
define( 'NONCE_SALT',       'YourNonceSalt');

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

define( 'SAVEQUERIES', true );

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

if( !defined('PLUGIN_ACTIVATED') ){
    activate_plugins( 'query-logger/query-logger.php');
    define('PLUGIN_ACTIVATED', TRUE);
}

