<?php
/**
 * Displays the icon navigation.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class="icon-navigation-wrapper d-none d-sm-none d-md-none d-lg-block">
	<nav id="icon-nav">
		<?php
		if ( has_nav_menu( 'secondary_nav' ) ) {
			Mfit_Menus::nav_menu(
				array(
					'theme_location'  => 'secondary_nav',
					'menu'            => 'secondary_nav',
					'container'       => 'div',
					'container_class' => 'icon-nav-wrapper',
					'menu_class'      => 'mfit-icon-menu',
					'menu_id'         => 'icon-menu',
				)
			);
		}
		?>
	</nav><!-- #icon-nav -->
</div><!-- .navigation-wrapper -->
