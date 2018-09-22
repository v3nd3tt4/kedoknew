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
define('DB_NAME', 'kedoknew1');

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
define('AUTH_KEY',         '$7_e+vz#XpKZPx5.*WkTS14ucle6[xAoygb+g;LH@Av76onR X6YrwngZr!YKjv.');
define('SECURE_AUTH_KEY',  'Jz@WTkI$.muH,AviA?cGGH+hT(UR[&k>G(I-lW0NTjN*2]Z%xp@^r,xXT^=JpdjD');
define('LOGGED_IN_KEY',    'xc~l 72!+#qmx9T:^4p/el7h D#}:cP80ut#M*HO1b<Q%EM[/8Jx+YmJLsx2z-0#');
define('NONCE_KEY',        '+@=pE7DY+,d>R,}+Sf,HUh]#B!P>?ha[3!!v=l&]qZL6a@n7688~cu(e;Zm`dAb1');
define('AUTH_SALT',        ' {(WZ_3D$@*D?vp8eIw(_^o?*}Gua@==g80Dx4=-sO8iU#ulZ=^xx^JDm=3^Ma-&');
define('SECURE_AUTH_SALT', '}|[WscdyXO.irys0^P,`vj]D%m*QeoOW_@S&%hzEOaQ<BYk_xHqb}DZ#lo06hr_$');
define('LOGGED_IN_SALT',   'b=5(#l%bbDN/G*.zkhZRT#Z$K^~f]U[JER]P`/~dW)iQ2On[Q1!_Q=>tj>lGb;9*');
define('NONCE_SALT',       'UdY[sAx35R;`[HH@;up*%U,KH/qM1NL!Tz$9F-(:eblFHuYb>KjEpF /s!I7Y%lI');

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
