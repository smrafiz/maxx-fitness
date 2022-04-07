<?php
/**
 * Displays header action buttons
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$images_uri = get_parent_theme_file_uri( 'assets/images/' );
?>

<div class="action-buttons">
	<div class="buttons-wrapper">
		<ul class="list-inline d-flex align-items-center justify-content-end mb-0">
			<li class="list-inline-item info-btn">
				<a class="d-block" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'form.svg' ); ?>" alt="<?php esc_html_e( 'Info Button', 'maxx-fitness' ); ?>">
				</a>
			</li>
			<li class="list-inline-item wishlist-btn">
				<a class="d-block" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'wishlist.svg' ); ?>" alt="<?php esc_html_e( 'Wishlist Button', 'maxx-fitness' ); ?>">
				</a>
			</li>
			<li class="list-inline-item login-btn">
				<a class="d-block" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'login.svg' ); ?>" alt="<?php esc_html_e( 'Login Button', 'maxx-fitness' ); ?>">
				</a>
			</li>
			<li class="list-inline-item cart-btn">
				<a class="d-block pos-r" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'cart.svg' ); ?>" alt="<?php esc_html_e( 'Cart Button', 'maxx-fitness' ); ?>">
					<span class="cart-icon-num"><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span>
				</a>
				<div class="cart-icon-products">
					<?php
					the_widget( 'WC_Widget_Cart' );
					?>
				</div>
			</li>
		</ul>
	</div><!-- .buttons-wrapper -->
</div><!-- .action-buttons -->
