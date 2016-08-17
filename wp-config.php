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
define('DB_NAME', 'sooryalaya');

/** MySQL database username */
define('DB_USER', 'sooryalaya');

/** MySQL database password */
define('DB_PASSWORD', 'hd9KHD5d0');

/** MySQL hostname */
define('DB_HOST', '192.168.12.210');

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
define('AUTH_KEY',         '|B/Ouv7?Zwx#cy]iYBNk,J2>md3<7h{*94~F72]Mw:LnsagUbloviuyvxEWo2@tF');
define('SECURE_AUTH_KEY',  '!Li{t1zCg_B ;NH1ZoH9-kb3{r?6c;!sH#V|7Le0nv$kM4i@2Y>1vR>Vj&R$r/-9');
define('LOGGED_IN_KEY',    'o<@8BKruI1u)90X@.(m g@7>Gf[5^4p+W<^ge/b?8o7M#^1KCwQr~$cF{3QY$<vc');
define('NONCE_KEY',        'GLYRvME^HY%82(MmnCXT|p}o_u1RZJA!N:k#0NmOD`TXGN_O-2ILVoGQs0W!G8Ai');
define('AUTH_SALT',        '?N2`H3,3vDgqjO{V8t 84!SI#?2yz4_6ZEQ HVI|2k+X{0dBqC}kaJRLS^&.o2+%');
define('SECURE_AUTH_SALT', 'L/jC0xC.3t$:&*u:n1(H^b >C!9--xP!6AA}+Dgx&.,OS(1j3.-7wT/]M^5?vaM2');
define('LOGGED_IN_SALT',   'qtaj):%Q<YV(_Px>4p0{WH@+,+cPEN|Ew}aHW^Id2rQ:WUiuap$?BpZS6~/cz,wH');
define('NONCE_SALT',       '?&H,rdW$PtB3-#%Z8B{W&~f>-[c^H]ZWaF$mgBXF}j|zNX)FM&S~FxKYw|BB{}VR');

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
