<?php
/**
 * The template used for displaying homepage slider.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$slides = get_theme_mod( 'mfit_home_top_slider', false );
?>

<div id="primary_slider" class="home-showcase swiper-container">
	<div class="swiper-wrapper">
		<?php
		foreach ( $slides as $slide ) {
			$img_id    = $slide['slide_image'];
			$title     = ! empty( $slide['title'] ) ? $slide['title'] : '';
			$subtitle  = ! empty( $slide['subtitle'] ) ? $slide['subtitle'] : '';
			$start_tag = ! empty( $slide['link'] ) ? 'a href="' . esc_url( $slide['link'] ) . '"' : 'div';
			$end_tag   = ! empty( $slide['link'] ) ? 'a' : 'div';

			$img_src = wp_get_attachment_image_src( $img_id, 'full' )[0];
			?>
			<div class="swiper-slide">
				<<?php echo $start_tag; ?> class="slide-inner pos-r image-in-bg size-cover" style="background-image:url(<?php echo esc_url( $img_src ); ?>)">
					<?php
					if ( ! empty( $title ) || ! empty( $subtitle ) ) {
						?>
						<div class="container">
							<div class="row">
								<div class="col-lg-12 pos-s">
									<div class="slide-content layer-animation-1">
										<?php
										if ( ! empty( $title ) ) {
											?>
											<h1 class="main-title"><span><?php echo $title; ?></span></h1>
											<?php
										}
										if ( ! empty( $subtitle ) ) {
											?>
											<p class="subtitle"><?php echo $subtitle; ?></p>
											<?php
										}
										?>
									</div> <!-- end of slide-content -->
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</<?php echo $end_tag; ?>>
			</div>
			<?php
		}
		?>
	</div>
	<!-- Slider Navigation -->
	<div class="swiper-arrow next slide"><i class="fas fa-chevron-right"></i></div>
	<div class="swiper-arrow prev slide"><i class="fas fa-chevron-left"></i></div>

	<!-- Slider Pagination -->
	<div class="swiper-pagination"></div>
</div>
