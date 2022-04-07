<?php
/**
 * Template used to display post content.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="col-12 col-lg-12">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-half pb-half post-item' ); ?>>
		<header class="entry-header">
			<?php
			// The Post Thumbnail.
			mfit_the_post_thumbnail( 'full' );

			if ( is_single() ) {
				the_title( '<h2 class="entry-title">', '</h2>' );
			} else {
				the_title(
					sprintf(
						'<h2 class="entry-title"><a href="%s" rel="bookmark">',
						esc_url( get_permalink() )
					),
					'</a></h2>'
				);
			}

			if ( 'post' === get_post_type() ) {
				?>
				<div class="entry-meta">
					<div class="meta-container">
						<?php mfit_posted_on(); ?>
						<?php mfit_posted_by(); ?>
						<?php mfit_comments_meta(); ?>
					</div>
				</div>
				<?php
			}
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<div class="post-content">
				<?php
				if ( is_single() ) {
					the_content();

					// This section is for pagination purpose for a long large post that is separated using nextpage tags.
					wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'maxx-fitness' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'maxx-fitness' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						)
					);

				} else {
					the_excerpt();
				}
				?>
			</div><!-- .post-content -->
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php
			if ( ! is_single() ) {
				?>
				<div class="more-link">
					<a href="<?php the_permalink(); ?>" class="mfit-btn primary"><?php echo esc_html__( 'Continue Reading', 'maxx-fitness' ); ?></a>
				</div>
				<?php
			} else {
				// Hide category and tag text for pages.
				if ( 'post' === get_post_type() ) {
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', 'maxx-fitness' ) );
					if ( $categories_list ) {
						/* translators: 1: list of categories. */
						printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'maxx-fitness' ) . '</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}

					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'maxx-fitness' ) );
					if ( $tags_list ) {
						/* translators: 1: list of tags. */
						printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'maxx-fitness' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
				}
			}
			?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
