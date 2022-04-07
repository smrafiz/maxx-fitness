<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	printf(
		'<p class="alert">%s</p>',
		esc_html__( 'This post is password protected. Enter the password to view comments.', 'maxx-fitness' )
	);
	return;
}
?>

<section id="comments" class="comments-area" aria-label="<?php esc_html__( 'Post Comments', 'maxx-fitness' ); ?>">
	<?php
	if ( have_comments() ) {
		?>
		<h2 class="comments-title">
			<?php
			$mfit_comment_count = get_comments_number();
			if ( '1' === $mfit_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'maxx-fitness' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $mfit_comment_count, 'comments title', 'maxx-fitness' ) ),
					number_format_i18n( $mfit_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comment-title -->

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'short_ping' => true,
						'callback'   => 'mfit_comment_callback',
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php
		// Comments Navigation.
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( '&larr; Previous', 'maxx-fitness' ),
				'next_text' => esc_html__( 'Next &rarr;', 'maxx-fitness' ),
			)
		);

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) {
			?>
			<p class="no-comments text-center"><?php esc_html_e( 'Comments are closed.', 'maxx-fitness' ); ?></p>
			<?php
		}
	}

	// The Comment Form.
	mfit_comment_form();
	?>
</section><!-- #comments -->
