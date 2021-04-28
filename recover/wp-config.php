<?php
define('WP_AUTO_UPDATE_CORE', false);// This setting was defined by WordPress Toolkit to prevent WordPress auto-updates. Do not change it to avoid conflicts with the WordPress Toolkit auto-updates feature.
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
define('DB_NAME', 't85757_wp680');

/** MySQL database username */
define('DB_USER', 't85757_wp680');

/** MySQL database password */
define('DB_PASSWORD', '.S6pfr1u2@');

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
define('AUTH_KEY',         'lgvkwxbx1uijbkghccjgwsvjcdcbhql9fpd4zq2lqrlq9nisuybgtmhefbbqofbz');
define('SECURE_AUTH_KEY',  'opvcclmlxszj2bsu75e8n3nawvrkmjnflmsy8zqwpgztpzvabdpfmlind6jmiuk0');
define('LOGGED_IN_KEY',    'afbhqpslqcbcp4hqn5iywh9uqfkj1axw4x6tdbxtjfl4xuhghn7cbxoil0vvl7ak');
define('NONCE_KEY',        'iipo8ywr5fkp2c7rvhwkh4amkxtlj9phgs6cd1n2n6wwqneax6lqt2vwuq8cnxfj');
define('AUTH_SALT',        'covz7lmhnffzwmdi9uccnt7thpweewzpqfpt8hzteot0pa2dsgbnqbqqqmn0diza');
define('SECURE_AUTH_SALT', 'eraidi0oepepmwyflgzwesnpcvwafxxe0yomvbhcau7bzx44hwqx88ysa213eeb3');
define('LOGGED_IN_SALT',   'jmgdxczz1ftzdrmsynx2sjhahjoycawr3ylfycn7lcv3a9t94klxznkd7uvidypp');
define('NONCE_SALT',       'w6yj3lcir1kvdujv1oqaelmpbazgaefe5nkxn5gzd1w6aqxrrh9md32xg0mxtri8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpvi_';

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
