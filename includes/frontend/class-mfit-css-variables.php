<?php
/**
 * CSS Variables Class.
 * This Class assigns CSS custom properties.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * SS Variables Class.
 *
 * @since v1.0.0
 */
class Mfit_CSS_Variables {

	/**
	 * Variables to include.
	 *
	 * @access private
	 * @var array
	 * @since 1.0.0
	 */
	private $variables = array();

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
	 * @return Mfit_Color_Patterns
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
		$this->colors();

		if ( empty( $this->variables ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'print' ) );
	}

	/**
	 * Add inline style for variables.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function print() {
		$theme_vars  = '';
		$theme_vars .= '
			:root {
				--mfit-text-color: ' . $this->variables['colors']['text'] . ';
				--mfit-primary-color: ' . $this->variables['colors']['primary'] . ';
				--mfit-secondary-color: ' . $this->variables['colors']['secondary'] . ';
				--mfit-tertiary-color: ' . $this->variables['colors']['tertiary'] . ';
				--mfit-offset-color: ' . $this->variables['colors']['offset'] . ';
				--mfit-border-color: ' . $this->variables['colors']['border'] . ';
		}';

		wp_add_inline_style( 'mfit-stylesheet', $theme_vars );
	}


	/**
	 * Colors.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->variables['colors']['text']      = get_theme_mod( 'mfit_text_color', '#242545' );
		$this->variables['colors']['primary']   = get_theme_mod( 'mfit_primary_color', '#F93001' );
		$this->variables['colors']['secondary'] = get_theme_mod( 'mfit_secondary_color', '#404040' );
		$this->variables['colors']['tertiary']  = get_theme_mod( 'mfit_tertiary_color', '#bfbfbf' );
		$this->variables['colors']['offset']    = get_theme_mod( 'mfit_offset_color', '#EFF5FC' );
		$this->variables['colors']['border']    = get_theme_mod( 'mfit_border_color', '#DDDDDD' );

		return $this;
	}
}
