<?php
/**
 * Displays the top bar.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$tb_phone      = get_theme_mod( 'mfit_header_phone' );
$tb_phone_url  = get_theme_mod( 'mfit_header_phone_url' );
$tb_page_title = get_theme_mod( 'mfit_header_page_title' );
$tb_page       = get_theme_mod( 'mfit_header_page_selector' );
?>

<div class="top-bar-wrapper">
	<div class="row align-items-center">
		<div class="col col-sm-4 col-md-4 col-lg-4 col-xl-4 d-none d-sm-block">
			<div class="header-socials">
				<?php
				if ( get_theme_mod( 'mfit_header_socials', 1 ) ) {
					echo do_shortcode( '[mfit_social_icons]' );
				}
				?>
			</div>
		</div>
		<div class="col-9 col-sm-6 col-md-4 col-lg-4 col-xl-4">
			<div class="top-bar-middle text-left text-sm-center">
				<div class="page-selector">
					<a class="color-text mfit-text" href="<?php echo esc_url( get_permalink( $tb_page ) ); ?>"><?php echo wp_kses_post( $tb_page_title ); ?></a>
				</div>
			</div>
		</div>
		<div class="col-3 col-sm-2 col-md-4 col-lg-4 col-xl-4">
			<div class="top-bar-right d-flex mb-0 align-items-center justify-content-end justify-content-md-end">
				<a class="d-flex header-phone mfit-text" href="tel:<?php echo esc_attr( $tb_phone_url ); ?>">
					<span class="d-none d-lg-inline"><?php echo esc_html( $tb_phone ); ?></span>
					<i class="fas fa-phone-alt d-block d-lg-none"></i>
				</a>
			</div>
		</div>
	</div>
</div>
