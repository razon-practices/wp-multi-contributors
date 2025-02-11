<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define('ABSPATH', dirname(dirname(__FILE__)) . '/wordpress/');

/*
 * Path to the theme to test with.
 *
 * The 'default' theme is symlinked from test/phpunit/data/themedir1/default into
 * the themes directory of the WordPress installation defined above.
 */
define('WP_DEFAULT_THEME', 'default');

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define('WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

// WARNING WARNING WARNING!
// These tests will DROP ALL TABLES in the database with the prefix named below.
// DO NOT use a production database or one that is shared with something else.

define('DB_NAME', getenv('WP_DB_NAME') ?: 'local');
define('DB_USER', getenv('WP_DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('WP_DB_PASS') ?: 'root');
define('DB_HOST', getenv('WP_DB_HOST') ?: 'localhost:/Users/razon/Library/Application Support/Local/run/LMmxIKyhy/mysql/mysqld.sock');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define('AUTH_KEY',         'B3*_-ijd[g[i1HE@U?r:S;{~b!c|/k#KR$FW{c}?c3l+X#37H8yMq#!!T[:ttk9q');
define('SECURE_AUTH_KEY',  'KRORH727K{n#_*JBQOz/26jX$MA*j -}KO/NIE*:C3h1+D?wN+H.Z5WTJ^]T.(?q');
define('LOGGED_IN_KEY',    ']XA=7(F.39u .tXPfAO-EdnR0SIXoN>;^drCWnfzud:5SQ&X&v<fc]i|zimTXasg');
define('NONCE_KEY',        'YjRnP71/<~Ij*@2-MI n92B}0zLWp`h*JFAcumK1aTb64~wf8ZX08?+Yu=qR?FPj');
define('AUTH_SALT',        'KdVS9 Fz.h uf`!}PnBEu%FIr!;kan$s-z_vqPs?&Gn(^Eq1~EdV{<|E(&pY`P$8');
define('SECURE_AUTH_SALT', 'E_+=6G@7g$wb|rNpg*^npdJ1bN?zF;`<UV*6)A5A5?{F-&_K;2I:?_TjO.j`.geA');
define('LOGGED_IN_SALT',   '1Z+%!V94d;RYf#[EnobfA{:SMQ9/9/PRSBEUR.zh2>MJ4waFvTg#y?E/S%$x$wC3');
define('NONCE_SALT',       'GBm;deME//H^_KU er$-Ua]rwU@;UC?w|,s! Uatkz*x/VGg$<<iit`tvbJA{:Tx');

$table_prefix = 'tests_';   // Only numbers, letters, and underscores please!

define('WP_TESTS_DOMAIN', 'example.org');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Test Blog');

define('WP_PHP_BINARY', 'php');

define('WPLANG', '');
