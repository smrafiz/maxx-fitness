<?php
/**
 * ACF Class.
 * This Class configures ACF to import local json files where
 * custom fields are stored.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * ACF Class.
 *
 * @since v1.0.0
 */
class Mfit_ACF {

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
	 * @since  1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Mfit_ACF
	 * @since  1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering ACF fields.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		if ( ! class_exists( 'ACF' ) ) {
			return;
		}

		// Add Options Page.
		$this->theme_options();

		// if ( '1' === get_option( 'options_mfit_enable_acf_admin' ) ) {
		// 	return;
		// }

		// add_filter( 'acf/settings/show_admin', array( $this, 'show_admin' ) );
	}

	/**
	 * Method to show admin panel.
	 *
	 * @access public
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function show_admin() {
		return false;
	}

	/**
	 * Method to show theme options.
	 *
	 * @access public
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function theme_options() {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => __( 'Theme Options', 'maxx-fitness' ),
				'menu_title' => __( 'Theme Options', 'maxx-fitness' ),
				'menu_slug'  => 'mfit-theme-options',
				'icon_url'   => 'dashicons-admin-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			)
		);
	}
}
