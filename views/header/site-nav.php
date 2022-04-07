<?php
/**
 * Displays the site navigation.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="navigation-wrapper d-none d-sm-none d-md-none d-lg-block">
	<nav id="main-nav">
		<?php
		if ( has_nav_menu( 'primary_nav' ) ) {
			Mfit_Menus::nav_menu(
				array(
					'theme_location' => 'primary_nav',
					'menu'           => 'primary_nav',
				)
			);
		}
		?>
	</nav><!-- #main-nav -->
</div><!-- .navigation-wrapper -->

<div id="mfit-menu-trigger" class="mobile-nav mfit-menu-trigger d-block d-sm-block d-md-block d-lg-none text-right">
	<div class="primary-nav">
		<button id="mfit-trigger-button" class="primary-nav-details">
			<span><?php echo esc_html__( 'Menu', 'maxx-fitness' ); ?></span>
			<i class="fa fa-bars"></i>
		</button>
	</div><!-- #primary-nav -->
</div><!-- #mfit-menu-trigger -->
