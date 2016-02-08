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
define('DB_NAME', 'acsm_372f76fd5eb09c3');

/** MySQL database username */
define('DB_USER', 'be692491198526');

/** MySQL database password */
define('DB_PASSWORD', '07bc5c05');

/** MySQL hostname */
define('DB_HOST', 'ap-cdbr-azure-east-c.cloudapp.net');

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
define('AUTH_KEY',         '&WS6y?+0S0+a)+FkUAyc!?-k{wC(Mp[_@Wy}*iEB(&=LYdR~/<s6^TIS.M=&++Ef');
define('SECURE_AUTH_KEY',  'u{f|`v`F rinF2c$3+2o{_y6p:c*YP#+6DM%{qxGo;eV+CoHohpb tp?y2/KasF}');
define('LOGGED_IN_KEY',    '9TpYs]_vUd`H-<-,EPwV8:NV[P/>d|BOTpPH$f9y9gT{330JL9#c.d(eXkT5*|wo');
define('NONCE_KEY',        'Uj~Pwtt4(nF&vG%@:-MTT5h9iRaV)TGHw-0/~VB,lF5Wfhr|-%|Xx[ke`[F7+-0Q');
define('AUTH_SALT',        '@~@G[Y~C.E7|z:N<#AO1R8b`}p5$6W@r8D@jnOkA5%LHP{uyW$M1[Xv_@E+pXZ?v');
define('SECURE_AUTH_SALT', '#KxrL/JvWJ&BY|R@IPmThzH}7+TSl| mG?n_pp8JG6d$o=-thXb&Ju 7O^;f6iN|');
define('LOGGED_IN_SALT',   '|-zE(h@leT@IGk)gK[kuw(vZIN>?y#9tL|fbQF#wkG4wWe<G5S.!1e_|^W(NMW?E');
define('NONCE_SALT',       'axpN!.>tiEn=`S<3E;92|hzs^bFq~h-b|6c6wgK=~UmHZW81>#|k/%OtQzU[8^/|');

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


