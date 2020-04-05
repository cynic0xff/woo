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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ru3VCC+kcjTQUlXIFZr/emduXOdnRfi/RyLMN4TPSoUYHSbVXoDeBWdp9pcIQAgXePHcnyjPboEqNMzWu8BLmw==');
define('SECURE_AUTH_KEY',  'ZTJ4p/kLdquqJxLVE+FN4xsfSbvxTB9M9NK236xoIKQij9BUtTlMo+JjjEoj3K2jGaUsTKDtYp907wA47IlDvw==');
define('LOGGED_IN_KEY',    'L7pBzJT7Y/SyIYf/pdHZ5hnolFZkXAQ0eyxHw4LvUa5pkKP9m59cbLDMQceU6ySalTvGK8VZVOnxfXNMLK7XkQ==');
define('NONCE_KEY',        '8q6FjSntOyHCTIjYYt6GmosX3AR6WafJHxUjLVUyfb99ybwWI1s3i6pbVf5Cq4o3wEYPVWty9BV48ecn/T8rEg==');
define('AUTH_SALT',        'iJHJFlhMX1GCqJV4eq4UQA3T49/gAhn6pycx+gtfOLZpC5aH50Kl9jqIO5WTVf4AblWpFBvUhd3IZKjV8ZxnRQ==');
define('SECURE_AUTH_SALT', 'RdvLnfVrRSWTGVU1GBXiSAgwN3dmJsFg0ab2nMZEQtPLV24e9Edak+AgXrRmJtiU7kXBV3sN3Bse53TJo24aNQ==');
define('LOGGED_IN_SALT',   'Via0QrZ917B0ZEKWxSgSSU4qkYmaxxYgpkVar4lfK++cupdN6QqC+jheq6mSQBZSZ3Hedo/jrpnFHw5YaoZtIg==');
define('NONCE_SALT',       'YrlsuNpOHAmlguDzhc4uBFMPQZNtg++ARYG7LIkDWHbRdxG4Vru4sFrrCf+ixcHZW0OIaooHkzSKDOQsDERVhw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
