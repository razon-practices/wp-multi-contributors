<?php
/**
 * Plugin Name: WP Multi Contributors
 * Description: Add multiple contributors to a post and display them on the frontend with their Gravatars.
 * Requires at least: 6.1
 * Requires PHP: 7.4
 * Plugin URI: https://example.com/plugin-uri
 * Author: Razon
 * Version: 1.0.0
 * Author URI: https://example.com/
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: wp-multi-contributors
 * Domain Path: /languages
 *
 * @package SimpleSlideshow
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants for the plugin.
 */
define( 'WPMC_PLUGIN_VERSION', '1.0.0' );
define( 'WPMC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPMC_PLUGIN_INC_DIR', WPMC_PLUGIN_DIR . 'inc' );
define( 'WPMC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Include required files for the plugin.
 */
function wpmc_include_files() {
	require_once WPMC_PLUGIN_INC_DIR . '/admin/metaboxes.php';
	require_once WPMC_PLUGIN_INC_DIR . '/frontend/content.php';
	require_once WPMC_PLUGIN_INC_DIR . '/frontend/enqueue.php';
}
wpmc_include_files();

/**
 * Load plugin textdomain.
 */
function wpmc_load_textdomain() {
	load_plugin_textdomain( 'wp-multi-contributors', false, WPMC_PLUGIN_DIR . '/languages' );
}
add_action( 'init', 'wpmc_load_textdomain' );
