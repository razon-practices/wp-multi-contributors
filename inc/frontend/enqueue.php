<?php
/**
 * Enqueue frontend scripts and styles.
 *
 * @package SimpleSlideshow
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue frontend scripts and styles.
 */
function wpmc_frontend_scripts() {
	if ( is_singular( 'post' ) ) {
		wp_enqueue_style(
			'frontend',
			WPMC_PLUGIN_URL . 'assets/css/frontend.css',
			array(),
			WPMC_PLUGIN_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'wpmc_frontend_scripts' );
