<?php
/**
 * Customizer Panels Class.
 * This Class registers Customizer Panels.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Panels Class.
 *
 * @since v1.0
 */
class Mfit_Customizer_Panels {

	/**
	 * Customizer Panels.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $panels = array();

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
	 * @return Mfit_Customizer_Panels
	 * @since  1.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer panels.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->set_panels()->add_panels();
	}

	/**
	 * Setting up panels.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_panels() {
		$this->panels['mfit_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Theme Options', 'maxx-fitness' ),
			'description' => esc_html__( 'Theme options & settings', 'maxx-fitness' ),
		);

		$this->panels['mfit_general_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'General', 'maxx-fitness' ),
			'description' => esc_html__( 'General settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		$this->panels['header_settings'] = array(
			'priority'    => 11,
			'title'       => esc_html__( 'Header', 'maxx-fitness' ),
			'description' => esc_html__( 'Logo and page-title settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		$this->panels['mfit_footer_settings'] = array(
			'priority'    => 12,
			'title'       => esc_html__( 'Footer', 'maxx-fitness' ),
			'description' => esc_html__( 'Footer settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		$this->panels['mfit_texts_colors_settings'] = array(
			'priority'    => 13,
			'title'       => esc_html__( 'Texts & Colors', 'maxx-fitness' ),
			'description' => esc_html__( 'Typography & Color settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		$this->panels['mfit_typography_settings'] = array(
			'priority'    => 10,
			'title'       => esc_html__( 'Typography', 'maxx-fitness' ),
			'description' => esc_html__( 'Typography settings', 'maxx-fitness' ),
			'panel'       => 'mfit_texts_colors_settings',
		);

		$this->panels['mfit_page_settings'] = array(
			'priority'    => 14,
			'title'       => esc_html__( 'Page', 'maxx-fitness' ),
			'description' => esc_html__( 'Page settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		$this->panels['mfit_blog_settings'] = array(
			'priority'    => 15,
			'title'       => esc_html__( 'Blog', 'maxx-fitness' ),
			'description' => esc_html__( 'Archives and single post settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
		);

		return $this;
	}

	/**
	 * Adding panels with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_panels() {
		if ( empty( $this->panels ) ) {
			return;
		}

		foreach ( $this->panels as $panel_id => $panel_args ) {
			Kirki::add_panel( $panel_id, $panel_args );
		}
	}
}
