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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '123456');

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
define('AUTH_KEY',         'SFz1mVceoapF)WrzO[eSn7vm3DC4x#A0Uz*]0swXoe mI1WDQi%{<Ml=J~T/1>-c');
define('SECURE_AUTH_KEY',  'C$i`0hkKD{e%:W#LBW,I?+46sAH2Y]CxlR2<!!PQ83a,IplPp=Z,Z%mT}D+&vdYT');
define('LOGGED_IN_KEY',    '~d*) iJId1Iwt5deo`0Nw0@DMK$n1bG=$D{mz^%Ua&eoz1<r8:{HGGoLcP_?8GC]');
define('NONCE_KEY',        ',e89R_55ynC,`Tu<B{^r`L Nc,r<P_+l>f:)/.*SWfhRemy&!tY$w~(;h)-SAqo]');
define('AUTH_SALT',        '_@0{8`9tk|}s<(gj/Ma*ERvOe{AK))p=G^IZGS%e#d&qn_U&4NTgF[p[<$Ne)Iz,');
define('SECURE_AUTH_SALT', 'HBz}p:$|hbs~>rHyL]?*MS3(q@IHMbcQpNGx(H[:QpwWf{8c))L_mFB%*#MhW&#,');
define('LOGGED_IN_SALT',   '|&O+PYM#yr///t$GmVPy 4XX|XG6/0egba[9F{n@;<8zV}q_mm0HCvU]5#|6U)8Y');
define('NONCE_SALT',       '()/0;=u f!u,zeFO7s@[znW+owfhDGc:X2f`E=xRC8!3=FSr~OVXN:uTY@[^k{`t');

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
