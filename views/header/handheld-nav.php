<?php
/**
 * Displays the handheld navigation.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<nav id="mfit-mobile-menu" class="mfit-menu d-block d-sm-block d-md-block d-lg-none">
	<button class="mfit-menu__close"><?php echo esc_html__( '&larr; Back', 'maxx-fitness' ); ?></button>
	<?php
	Mfit_Menus::nav_menu(
		array(
			'theme_location'  => 'handheld_nav',
			'menu'            => 'handheld_nav',
			'container'       => 'div',
			'container_class' => 'nav-wrapper',
			'menu_class'      => 'mfit-menu__items',
			'menu_id'         => 'handheld-menu',
		)
	);
	?>
	<div class="mobile-menu-footer">
		<div class="header-socials">
			<?php
			if ( get_theme_mod( 'mfit_header_socials', 1 ) ) {
				echo do_shortcode( '[mfit_social_icons]' );
			}
			?>
		</div>
	</div>
</nav>
