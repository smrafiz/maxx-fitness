<?php
/**
 * Customizer Sections Class.
 * This Class registers Customizer Sections.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Sections Class.
 *
 * @since v1.0
 */
class Mfit_Customizer_Sections {

	/**
	 * Customizer Sections.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $sections = array();

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
	 * @return Mfit_Customizer_Sections
	 * @since  1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Customizer sections.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->set_sections()->add_sections();
	}

	/**
	 * Setting up sections.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function set_sections() {
		$this->sections['mfit_header_styles'] = array(
			'title'       => esc_html__( 'Header Styles', 'maxx-fitness' ),
			'description' => esc_html__( 'Header Style settings', 'maxx-fitness' ),
			'panel'       => 'header_settings',
			'priority'    => 10,
		);

		$this->sections['mfit_header_topbar'] = array(
			'title'       => esc_html__( 'Header Top Bar', 'maxx-fitness' ),
			'description' => esc_html__( 'Header top bar settings', 'maxx-fitness' ),
			'panel'       => 'header_settings',
			'priority'    => 11,
		);

		$this->sections['mfit_sticky_header'] = array(
			'title'       => esc_html__( 'Sticky Header', 'maxx-fitness' ),
			'description' => esc_html__( 'Sticky header settings', 'maxx-fitness' ),
			'panel'       => 'header_settings',
			'priority'    => 15,
		);

		$this->sections['mfit_footer_styles'] = array(
			'title'       => esc_html__( 'Footer Styles', 'maxx-fitness' ),
			'description' => esc_html__( 'footer style settings', 'maxx-fitness' ),
			'panel'       => 'mfit_footer_settings',
			'priority'    => 10,
		);

		$this->sections['mfit_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'maxx-fitness' ),
			'description' => esc_html__( 'footer copyright settings', 'maxx-fitness' ),
			'panel'       => 'mfit_footer_settings',
			'priority'    => 15,
		);

		$this->sections['mfit_footer_copyright'] = array(
			'title'       => esc_html__( 'Footer Copyright', 'maxx-fitness' ),
			'description' => esc_html__( 'footer copyright settings', 'maxx-fitness' ),
			'panel'       => 'mfit_footer_settings',
			'priority'    => 15,
		);

		$this->sections['mfit_typography_body'] = array(
			'title'       => esc_html__( 'Body', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify the body typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 10,
		);

		$this->sections['mfit_typography_nav'] = array(
			'title'       => esc_html__( 'Menu', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify the Navigation Menu typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 20,
		);

		$this->sections['mfit_typography_h1'] = array(
			'title'       => esc_html__( 'Heading 1', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h1 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 30,
		);

		$this->sections['mfit_typography_h2'] = array(
			'title'       => esc_html__( 'Heading 2', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h2 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 40,
		);

		$this->sections['mfit_typography_h3'] = array(
			'title'       => esc_html__( 'Heading 3', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h3 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 50,
		);

		$this->sections['mfit_typography_h4'] = array(
			'title'       => esc_html__( 'Heading 4', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h4 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 60,
		);

		$this->sections['mfit_typography_h5'] = array(
			'title'       => esc_html__( 'Heading 5', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h5 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 70,
		);

		$this->sections['mfit_typography_h6'] = array(
			'title'       => esc_html__( 'Heading 6', 'maxx-fitness' ),
			'description' => esc_html__( 'Specify h6 typography.', 'maxx-fitness' ),
			'panel'       => 'mfit_typography_settings',
			'priority'    => 80,
		);

		$this->sections['mfit_color_settings'] = array(
			'title'       => esc_html__( 'Colors', 'maxx-fitness' ),
			'description' => esc_html__( 'Color scheme settings', 'maxx-fitness' ),
			'panel'       => 'mfit_texts_colors_settings',
			'priority'    => 10,
		);

		$this->sections['mfit_showcase_slider'] = array(
			'title'       => esc_html__( 'Homepage Showcase Slider', 'maxx-fitness' ),
			'description' => esc_html__( 'Homepage showcase slider settings', 'maxx-fitness' ),
			'panel'       => 'mfit_page_settings',
			'priority'    => 5,
		);

		$this->sections['mfit_pagetitle'] = array(
			'title'       => esc_html__( 'Page Title Banner', 'maxx-fitness' ),
			'description' => esc_html__( 'Page title banner settings', 'maxx-fitness' ),
			'panel'       => 'mfit_page_settings',
			'priority'    => 10,
		);

		$this->sections['mfit_breadcrumbs'] = array(
			'title'       => esc_html__( 'Breadcrumbs', 'maxx-fitness' ),
			'description' => esc_html__( 'Breadcrumbs settings', 'maxx-fitness' ),
			'panel'       => 'mfit_page_settings',
			'priority'    => 15,
		);

		$this->sections['mfit_page_styles'] = array(
			'title'       => esc_html__( 'Page Styles', 'maxx-fitness' ),
			'description' => esc_html__( 'Page style settings', 'maxx-fitness' ),
			'panel'       => 'mfit_page_settings',
			'priority'    => 20,
		);

		$this->sections['mfit_archive_settings'] = array(
			'title'       => esc_html__( 'Archives', 'maxx-fitness' ),
			'description' => esc_html__( 'Archive settings', 'maxx-fitness' ),
			'panel'       => 'mfit_blog_settings',
			'priority'    => 10,
		);

		// $this->sections['mfit_single_settings'] = array(
		// 	'title'       => esc_html__( 'Single Post', 'maxx-fitness' ),
		// 	'description' => esc_html__( 'Single post settings', 'maxx-fitness' ),
		// 	'panel'       => 'mfit_blog_settings',
		// 	'priority'    => 15,
		// );

		$this->sections['mfit_social_media'] = array(
			'title'       => esc_html__( 'Social Media', 'maxx-fitness' ),
			'description' => esc_html__( 'Please add your social media profile information', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
			'priority'    => 20,
		);

		$this->sections['mfit_integrations'] = array(
			'title'       => esc_html__( 'Integrations', 'maxx-fitness' ),
			'description' => esc_html__( 'Integrations settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
			'priority'    => 25,
		);

		$this->sections['mfit_extra_settings'] = array(
			'title'       => esc_html__( 'Extra', 'maxx-fitness' ),
			'description' => esc_html__( 'Extra settings', 'maxx-fitness' ),
			'panel'       => 'mfit_settings',
			'priority'    => 30,
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
	private function add_sections() {
		if ( empty( $this->sections ) ) {
			return;
		}

		foreach ( $this->sections as $section_id => $section_args ) {
			Kirki::add_section( $section_id, $section_args );
		}
	}
}
