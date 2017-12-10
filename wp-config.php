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
define('DB_NAME', 'music');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '_r=epWP#*%N..~#g4[CiXW9|bc@{)UZ$i5-9N_HjoW^F+7S`f{uz]x;~(@vR40qZ');
define('SECURE_AUTH_KEY',  '&EKMz+$*]^]+<+-g6(1)C5n=I@7Y:);A!_0u[N2>aJx=o#`na1aXAj,w^*+&Pu*F');
define('LOGGED_IN_KEY',    '*KKl,W`1M%M-5Z1]Ww+T5G0U2UXxbZ]7FH_[pJeV4XkjWOS#_ R0C GQAMFYf!FI');
define('NONCE_KEY',        '94!lNjd*4&R>a{~4W#VU$T^Y%iN#KSR9wW)u|?F=?)pmjWzo:72$Bk:W4cXSeB9$');
define('AUTH_SALT',        'D+S_a]B~[qdpO,?wa.Hm>N(A8#YjJJ!<4qi@<6ZO@t5Qt+B<XMN4Zcz8rY?a.[d>');
define('SECURE_AUTH_SALT', '3-I3^VyqdIyfnyR`yhQ},a3wuyi,Pk|Vp:8odHcnJ4D0!@N9Zq$Nl_Dz4`bdQTUw');
define('LOGGED_IN_SALT',   'v[3<TKS0?v)16a7;;ge}; Q1I&^,{CA?1a vDG-ZO,nT[DH@~ww$$kfIwaHXP&.N');
define('NONCE_SALT',       'WI-DXsK}Ly]jq]=Au*}(YQH0QGi0tBT^Zx>+oCyF3d%ThEGwabbZr:;A=p`{x]cA');

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
