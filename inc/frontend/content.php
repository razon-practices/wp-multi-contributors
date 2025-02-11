<?php
/**
 * Metaboxes.
 *
 * @package WPMC
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filter post content to display contributors on the frontend.
 *
 * @param string $content The original post content.
 * @return string The modified post content with contributors appended.
 * @since 1.0.0
 */
function wpmc_multi_contributors_display( $content ) {
	if ( is_singular( 'post' ) ) {
		$contributors = get_post_meta( get_the_ID(), '_wpmc_author_list', true );

		if ( ! empty( $contributors ) && is_array( $contributors ) ) :
			ob_start(); ?>
				<div class="wpmc-contributors">
					<h3><?php echo esc_html__( 'Contributors', 'wp-multi-contributors' ); ?></h3>
					<?php
					foreach ( $contributors as $contributor_id ) :
						$user = get_userdata( $contributor_id );
						if ( $user ) :
							$avatar           = get_avatar( $user->ID, 46 );
							$user_description = get_the_author_meta( 'description', $user->ID );
							?>
							<div class="contributor">
								<a
								class="contributor-avatar"
								href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
									<?php echo wp_kses_post( $avatar ); ?>
								</a>

								<div class="contributor-info">
									<a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
										<?php echo esc_html( $user->display_name ); ?>
									</a>
									<?php if ( $user_description ) : ?>
										<p><?php echo esc_html( $user_description ); ?></p>
									<?php endif; ?>
								</div>
								</a>
							</div>
							<?php
						endif;
					endforeach;
					?>
				</div>
			<?php
			$content .= ob_get_clean();
		endif;
	}

	return $content;
}
add_filter( 'the_content', 'wpmc_multi_contributors_display' );
