<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'queenb_wp169');

/** MySQL database username */
define('DB_USER', 'queenb_wp169');

/** MySQL database password */
define('DB_PASSWORD', '1.36RSPc0[');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'pr3m05lvwefgc2mkksflfa9zv2t28ohxxr358szkkjawzoio6wysxzw2iufnfi8l');
define('SECURE_AUTH_KEY',  'qfrwhvtxysuzvvzvkn43vczmhletnblb6ireixpmvbrpm1emi7svx5tbstoqtstx');
define('LOGGED_IN_KEY',    'l0psxe6qmqrffndggelq3gsu6o87auooineqvzvxvazmutx3y6jdvkbzvgvxbu63');
define('NONCE_KEY',        'dhe1jxccvxqkeestnqj4ap5goglvhnx49eekhnmdevielsgd4eo07lye4xoexpfa');
define('AUTH_SALT',        '3fzepypgh9al2krjwgu56mwms7wbzrtilwx7rcwovjqxhkwa3ihpd8v6ja9qjlnc');
define('SECURE_AUTH_SALT', 'jnkpqt02szuuiamtozgunvvuktb5apnqng6taera6dncyanx1t07rpzps4est2ub');
define('LOGGED_IN_SALT',   'r32dzlzr8za2286u4gxiohfd1xk7alosiiuvr3ji5bnhw92v3adrxnkgkd53qwkq');
define('NONCE_SALT',       'skkofhoizqkcrh5vqws9ks1krldtwfuonoarhaclpsvmdar1rso7e0hs8abvf8e4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'eue_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_AUTO_UPDATE_CORE', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
