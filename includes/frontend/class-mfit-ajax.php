<?php
/**
 * Ajax Class.
 * This Class processes the ajax requests.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Ajax Class.
 *
 * @since v1.0.0
 */
class Mfit_Ajax {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Mfit_Ajax
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Colors.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		// Mini cart template.
		add_action( 'wp_ajax_nopriv_load_template', array( $this, 'load_template' ) );
		add_action( 'wp_ajax_load_template', array( $this, 'load_template' ) );

		// Remove product from mini cart.
		add_action( 'wp_ajax_product_remove', 'product_remove' );
		add_action( 'wp_ajax_nopriv_product_remove', 'product_remove' );
	}

	/**
	 * Load template.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function load_template() {
		wc_get_template_part(
			'ajax/' . sanitize_text_field( $_POST['template'] ),
			sanitize_text_field( $_POST['part'] )
		);

		wp_die();
	}

	public function product_remove() {
		// Get mini cart.
		ob_start();

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			if ( $cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key'] ) {
				WC()->cart->remove_cart_item( $cart_item_key );
			}
		}

		WC()->cart->calculate_totals();
		WC()->cart->maybe_set_cart_cookies();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned.
		$data = array(
			'fragments' => apply_filters(
				'woocommerce_add_to_cart_fragments',
				array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() ),
		);

		wp_send_json( $data );

		die();
	}
}
