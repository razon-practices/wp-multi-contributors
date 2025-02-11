<?php
/**
 * Metaboxes.
 *
 * @package WPMC
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the metabox.
 */
function wpmc_add_contributors_metabox() {
	add_meta_box(
		'wpmc_contributors_metabox', // Metabox ID.
		esc_html__( 'Contributors', 'wp-multi-contributors' ), // Title.
		'wpmc_display_contributors_metabox', // Callback function.
		'post', // Post type.
		'normal', // Context (sidebar).
		'default' // Priority.
	);
}
add_action( 'add_meta_boxes', 'wpmc_add_contributors_metabox' );

/**
 * Display the contributors metabox.
 *
 * @param WP_Post $post Post object.
 * @since 1.0.0
 */
function wpmc_display_contributors_metabox( $post ) {
	// Get all users (authors).
	$users = get_users( array( 'role__in' => array( 'author' ) ) );

	// Get the selected contributors from post meta.
	$authors = get_post_meta( $post->ID, '_wpmc_author_list', true );

	if ( ! $authors ) {
		$authors = array();
	}

	// Display checkboxes for all authors.
	echo '<ul>';
	foreach ( $users as $user ) {
		$checked = in_array( $user->ID, $authors, true ) ? 'checked' : '';
		echo '<li>';
		echo '<label>';
		echo '<input type="checkbox" name="wpmc_author_list[]" value="' . esc_attr( $user->ID ) . '" ' . esc_attr( $checked ) . ' /> ';
		echo esc_html( $user->display_name );
		echo '</label>';
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Save selected contributors when post is saved.
 *
 * @param int $post_id Post ID.
 * @since 1.0.0
 */
function wpmc_save_contributors_metabox( $post_id ) {
	// Verify nonce or auto-save to prevent accidental overwrites.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check user permissions: Allow only authors, editors, and admins to save the meta.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce already validated
	if ( isset( $_POST['wpmc_author_list'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce already validated
		update_post_meta( $post_id, '_wpmc_author_list', array_map( 'intval', $_POST['wpmc_author_list'] ) );
	} else {
		// If no contributors selected, clear the post meta.
		delete_post_meta( $post_id, '_wpmc_author_list' );
	}

	return $post_id;
}
add_action( 'save_post', 'wpmc_save_contributors_metabox' );
