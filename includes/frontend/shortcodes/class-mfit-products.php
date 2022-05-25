<?php
/**
 * Products Shortcode Class.
 *
 * This class renders products in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Sale Products Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Products {

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
	 * @return Mfit_Products
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
		add_shortcode( 'mfit_products', array( $this, 'shortcode' ) );
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
			array(
				'limit'     => '4',
				'ids'       => '',
				'columns'   => 4,
				'attribute' => '',
				'terms'     => '',
				'orderby'   => 'date',
				'on_sale'   => false,
			),
			$atts
		);
		$result = '';

		ob_start();

		?>
		<div class="mfit-products-container mfit-column-<?php echo esc_attr( $atts['columns'] ); ?>">
			<?php
			echo do_shortcode(
				'[products
					limit="' . absint( $atts['limit'] ) . '"
					ids="' . esc_html( $atts['ids'] ) . '"
					attribute="' . esc_html( $atts['attribute'] ) . '"
					terms="' . esc_html( $atts['terms'] ) . '"
					orderby="' . esc_html( $atts['orderby'] ) . '"
					on_sale="' . $atts['on_sale'] . '"
				]'
			);
			?>
		</div>

		<?php

		$result .= ob_get_clean();

		return $result;
	}
}
