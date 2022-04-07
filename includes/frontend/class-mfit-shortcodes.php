<?php
/**
 * Main Shortcodes Class.
 *
 * This class registers necessary shortcodes to render in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Shortcodes Class.
 *
 * @since  1.0.0
 */
class Mfit_Shortcodes {

	/**
	 * Base Class.
	 *
	 * @access private
	 * @var object
	 * @since 1.0.0
	 */
	private $base;

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
	 * @return Mfit_Shortcodes
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to register all shortcodes.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		$this->base = Mfit_Base::get_instance();

		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	/**
	 * Stores all the shortcode classes inside an array.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @return array Full list of classes
	 */
	private function get_shortcodes() {
		return array(
			Mfit_Social_Icons::class,
			Mfit_Sale_Products::class,
			Mfit_Footer_Payment::class,
			Mfit_Product_Categories::class,
		);
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_shortcodes() {
		foreach ( $this->get_shortcodes() as $shortcode ) {
			$this->base::require_service( $shortcode );
		}
	}
}
