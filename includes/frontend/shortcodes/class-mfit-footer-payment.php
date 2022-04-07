<?php
/**
 * Footer Payment Logo Shortcode Class.
 *
 * This class renders social icons in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Footer Payment Logo Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Footer_Payment {

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
	 * @return Mfit_Footer_Payment
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
		add_shortcode( 'mfit_footer_payment_logos', array( $this, 'shortcode' ) );
	}

	/**
	 * Method to render the shortcode.
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

		$logos = array(
			'paypal.svg',
			'paypal-r.svg',
			'mastercard.svg',
			'sepa.png',
			'amex.png',
			'visa.svg',
		);
		?>
		<div class="footer-payment-wrapper">
			<ul class="mb-0">
				<?php
				foreach ( $logos as $logo ) {
					echo '<li><img width="200" height="50" src="' . esc_url( get_template_directory_uri() . '/assets/images/' . $logo ) . '" alt="Footer Payment Logo"></li>';
				}
				?>
			</ul>
		</div>

		<?php
		$result .= ob_get_clean();

		return $result;
	}
}
