<?php
/**
 * Displays the mobile bottom bar.
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
<div class="mobile-bar-inner">
	<div class="buttons-wrapper">
		<ul class="list-inline d-flex align-items-center justify-content-center mb-0">
			<li class="list-inline-item search-btn">
				<a class="d-block pos-r" href="#">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'header-search.svg' ); ?>" alt="<?php esc_html_e( 'Search Button', 'maxx-fitness' ); ?>">
				</a>
			</li>
			<li class="list-inline-item wishlist-btn">
				<a class="pos-r" href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'wishlist.svg' ); ?>" alt="<?php esc_html_e( 'Wishlist Button', 'maxx-fitness' ); ?>">
					<span class="wishlist-icon-num"><?php echo absint( yith_wcwl_count_all_products() ); ?></span>
				</a>
			</li>
			<li class="list-inline-item login-btn pos-r">
				<a class="d-block" href="">
					<img width="30" height="30" src="<?php echo esc_url( $images_uri . 'login.svg' ); ?>" alt="<?php esc_html_e( 'Login Button', 'maxx-fitness' ); ?>">
				</a>
				<div class="login-expanded">
					<ul class="popup-inner <?php echo is_user_logged_in() ? esc_attr( 'logged-in' ) : esc_attr( 'no-login' ); ?>">
						<?php
						if ( is_user_logged_in() ) {
							?>
							<li class="mfit-account"><a href="/my-account/">Mein Konto</a></li>
							<li class="mfit-orders"><a href="/my-account/orders/">Meine Bestellungen</a></li>
							<li class="mfit-recently-viewed"><a href="/my-account/recently-viewed-products/">Kürzlich angesehen</a></li>
							<li class="mfit-help"><a href="/service-formular/">Hilfe</a></li>
							<li class="mfit-logout"><a href="<?php echo wp_logout_url( '/' ); ?>">Abmelden</a></li>
							<?php
						} else {
							?>
							<li class="mfit-login"><a href="/my-account/">Anmeldung</a></li>
							<li class="mfit-help"><a href="/service-formular/">Hilfe</a></li>
							<?php
						}
						?>
					</ul>
				</div>
			</li>
			<li class="list-inline-item cart-btn">
				<a class="pos-r" href="#">
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
</div>
