<?php
/**
 * Products Shortcode Class.
 *
 * This class renders recently viewed products in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Recently Viewed Products Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Recently_Viewed_Products {

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
	 * @return Mfit_Recently_Viewed_Products
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to load the shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'mfit_recently_viewed_products', array( $this, 'shortcode' ) );
	}

	/**
	 * Method to render the shortcodes.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param mixed $atts shortcode attributes.
	 * @return void|string
	 */
	public function shortcode( $atts ) {
		$atts   = shortcode_atts(
			array(),
			$atts
		);
		$result = '';

		ob_start();

		$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
		$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

		if ( empty( $viewed_products ) ) {
			echo '<div class="no-recent-products text-center">';
			echo '<p class="mb-0">Sie haben sich noch keine Produkte angesehen.</p>';
			echo '</div>';

			return;
		}

		$product_ids = implode( ',', $viewed_products );
		?>
		<div class="mfit-products-container mfit-column-4">
			<?php
			echo do_shortcode(
				'[products
					limit="10"
					ids="' . esc_html( $product_ids ) . '"
				]'
			);
			?>
		</div>
		<?php
		$result .= ob_get_clean();

		return $result;
	}
}
