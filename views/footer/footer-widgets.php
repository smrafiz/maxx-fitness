<?php
/**
 * Displays the footer widgets.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="footer-widget-area">
	<div class="<?php mfit_footer_container(); ?>">
		<div class="row">
			<div class="footer-top-logo col-12">
				<?php
				$footer_logo = get_theme_mod( 'mfit_footer_logo', false );

				if ( ! empty( $footer_logo ) ) {
					echo '<div class="footer-logo-inner text-center">';
						$attachment_id = attachment_url_to_postid( $footer_logo );

						$image_size = 'full';
						$alt_text   = trim( wp_strip_all_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

						echo wp_get_attachment_image(
							$attachment_id,
							$image_size,
							false,
							array(
								'class' => 'footer-logo',
								'alt'   => esc_attr( $alt_text ),
							)
						);
					echo '</div>';
				}
				?>
			</div>
		</div>
		<div class="row">
			<div id="footer-top-col-1" class="footer-top-column mb-half col-12 col-sm-12 col-md-12 col-lg-6">
				<?php
				if ( is_active_sidebar( 'mfit-footer-top-col-1' ) ) {
					dynamic_sidebar( 'mfit-footer-top-col-1' );
				}
				?>
			</div>
			<div id="footer-top-col-2" class="footer-top-column mb-half col-12 col-sm-12 col-md-12 col-lg-6">
				<?php
				if ( is_active_sidebar( 'mfit-footer-top-col-2' ) ) {
					dynamic_sidebar( 'mfit-footer-top-col-2' );
				}
				?>
			</div>
		</div>
		<div class="row">
			<?php
			$column_count = 4;

			for ( $footer_no = 1; $footer_no <= $column_count; $footer_no++ ) {
				echo '<div id="footer-bottom-col-' . esc_attr( $footer_no ) . '" class="footer-column mb-half col-12 col-sm-12 col-md-6 col-lg-3">';
				if ( is_active_sidebar( 'mfit-footer-bottom-col-' . esc_attr( $footer_no ) ) ) {
					dynamic_sidebar( 'mfit-footer-bottom-col-' . esc_attr( $footer_no ) );
				}
				echo '</div>';
			}
			?>
		</div>
	</div>
</div><!-- .footer-widget-area -->
