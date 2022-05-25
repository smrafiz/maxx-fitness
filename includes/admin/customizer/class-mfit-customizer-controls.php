<?php
/**
 * Customizer Controls Class.
 * This Class registers Customizer Controls.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Customizer Controls Class.
 *
 * @since v1.0
 */
class Mfit_Customizer_Controls {

	/**
	 * Kirki Configuration ID.
	 *
	 * @access public
	 * @var string
	 * @since  1.0.0
	 */
	public $config_id;

	/**
	 * Customizer Controls.
	 *
	 * @access public
	 * @var array
	 * @since  1.0.0
	 */
	public $controls = array();

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
	 * @return Mfit_Customizer_Controls
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
		$this->config_id = 'mfit_theme';
		$this->header()->footer()->typography()->colors()->page()
		->blog()->socials()->integrations()->extras()->add_controls();
	}

	/**
	 * Adding controls with the help of Kirki.
	 *
	 * @access private
	 * @return void
	 *
	 * @since 1.0.0
	 */
	private function add_controls() {
		if ( empty( $this->controls ) ) {
			return;
		}

		foreach ( $this->controls as $control ) {
			Kirki::add_field( $this->config_id, $control );
		}
	}

	/**
	 * Header controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function header() {
		$this->controls[] = array(
			'settings'    => 'mfit_logo_padding',
			'label'       => esc_html__( 'Logo Padding', 'maxx-fitness' ),
			'description' => esc_html__( 'Logo top/bottom padding. Default: 0.1rem.', 'maxx-fitness' ),
			'section'     => 'mfit_header_styles',
			'type'        => 'dimensions',
			'priority'    => 20,
			'default'     => array(
				'padding-top'    => '0.1rem',
				'padding-bottom' => '0.1rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'maxx-fitness' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'maxx-fitness' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '.site-branding .logo',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'mfit_enable_100_header',
			'label'       => esc_html__( '100% Header?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable 100% header width, regardless of container.', 'maxx-fitness' ),
			'section'     => 'mfit_header_styles',
			'type'        => 'toggle',
			'priority'    => 25,
			'default'     => 0,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_bg_color',
			'label'       => esc_html__( 'Header Background Color', 'maxx-fitness' ),
			'description' => esc_html__( 'Please choose the header background color', 'maxx-fitness' ),
			'section'     => 'header_image',
			'type'        => 'color',
			'priority'    => 30,
			'choices'     => array(
				'alpha' => true,
			),
			'default'     => '#fff',
			'output'      => array(
				array(
					'element'  => 'header .header-area',
					'property' => 'background-color',
				),
			),
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'settings'    => 'mfit_enable_sticky_header',
			'label'       => esc_html__( 'Enable Sticky Header?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable sticky header.', 'maxx-fitness' ),
			'section'     => 'mfit_sticky_header',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_socials',
			'label'       => esc_html__( 'Enable Header Social Icons?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable header social icons.', 'maxx-fitness' ),
			'section'     => 'mfit_header_topbar',
			'type'        => 'toggle',
			'priority'    => 10,
			'default'     => 1,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_page_title',
			'label'       => esc_html__( 'Top bar page title', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter header top bar page title.', 'maxx-fitness' ),
			'section'     => 'mfit_header_topbar',
			'type'        => 'textarea',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_page_selector',
			'label'       => esc_html__( 'Select Top Bar Page', 'maxx-fitness' ),
			'description' => esc_html__( 'Please select header top bar page.', 'maxx-fitness' ),
			'section'     => 'mfit_header_topbar',
			'type'        => 'dropdown-pages',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_phone',
			'label'       => esc_html__( 'Top Bar Phone Text', 'maxx-fitness' ),
			'description' => esc_html__( 'Enter header top bar phone text.', 'maxx-fitness' ),
			'section'     => 'mfit_header_topbar',
			'type'        => 'text',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_header_phone_url',
			'label'       => esc_html__( 'Top Bar Phone URL', 'maxx-fitness' ),
			'description' => esc_html__( 'Enter header top bar phone URL.', 'maxx-fitness' ),
			'section'     => 'mfit_header_topbar',
			'type'        => 'text',
			'priority'    => 11,
		);

		return $this;
	}

	/**
	 * Footer controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function footer() {
		$this->controls[] = array(
			'type'        => 'image',
			'settings'    => 'mfit_footer_logo',
			'label'       => esc_html__( 'Footer Top Logo', 'maxx-fitness' ),
			'description' => esc_html__( 'Please upload footer top logo (SVG preferred)', 'maxx-fitness' ),
			'section'     => 'mfit_footer_styles',
			'priority'    => 11,
			'transport'   => 'auto',
		);

		$this->controls[] = array(
			'type'        => 'color',
			'settings'    => 'mfit_footer_bgc',
			'label'       => esc_html__( 'Footer background', 'maxx-fitness' ),
			'description' => esc_html__( 'Please choose the footer background color', 'maxx-fitness' ),
			'section'     => 'mfit_footer_styles',
			'priority'    => 12,
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element'  => '#colophon',
					'property' => 'background-color',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'mfit_footer_padding',
			'label'       => esc_html__( 'Footer Padding', 'maxx-fitness' ),
			'description' => esc_html__( 'Footer top/bottom padding. Default: 7rem.', 'maxx-fitness' ),
			'section'     => 'mfit_footer_styles',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '7rem',
				'padding-bottom' => '7rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'maxx-fitness' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'maxx-fitness' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#colophon',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'mfit_enable_100_footer',
			'label'       => esc_html__( '100% Footer?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable 100% footer width, regardless of container.', 'maxx-fitness' ),
			'section'     => 'mfit_footer_styles',
			'type'        => 'toggle',
			'priority'    => 20,
			'default'     => 0,
		);

		$this->controls[] = array(
			'type'        => 'editor',
			'settings'    => 'mfit_footer_copyright_text',
			'label'       => esc_html__( 'Footer Copyright Text', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter footer copyright text.', 'maxx-fitness' ),
			'section'     => 'mfit_footer_copyright',
			'priority'    => 10,
		);

		return $this;
	}

	/**
	 * Typography controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function typography() {
		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_body_font',
			'label'     => esc_html__( 'Body Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_body',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 10,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'body, button, input, select, textarea',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_nav_font',
			'label'     => esc_html__( 'Menu Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_nav',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'uppercase',
			),
			'priority'  => 15,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => '#main-menu li a',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_icon_nav_font',
			'label'     => esc_html__( 'Icon Menu Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_nav',
			'default'   => array(
				'font-size'      => '1.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'capitalize',
			),
			'priority'  => 16,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => '#icon-menu > li a',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h1_font',
			'label'     => esc_html__( 'Heading-1 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h1',
			'default'   => array(
				'font-size'      => '4rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 20,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h1, .h1',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h2_font',
			'label'     => esc_html__( 'Heading-2 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h2',
			'default'   => array(
				'font-size'      => '3.2rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 25,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h2, .h2',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h3_font',
			'label'     => esc_html__( 'Heading-3 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h3',
			'default'   => array(
				'font-size'      => '2.8rem',
				'line-height'    => '1.2',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 30,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h3, .h3',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h4_font',
			'label'     => esc_html__( 'Heading-4 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h4',
			'default'   => array(
				'font-size'      => '2.4rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 35,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h4, .h4',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h5_font',
			'label'     => esc_html__( 'Heading-5 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h5',
			'default'   => array(
				'font-size'      => '2rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 40,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h5, .h5',
				),
			),
		);

		$this->controls[] = array(
			'type'      => 'typography',
			'settings'  => 'mfit_h6_font',
			'label'     => esc_html__( 'Heading-6 Typography', 'maxx-fitness' ),
			'section'   => 'mfit_typography_h6',
			'default'   => array(
				'font-size'      => '1.6rem',
				'line-height'    => '1.5',
				'letter-spacing' => '0',
				'text-transform' => 'none',
			),
			'priority'  => 45,
			'transport' => 'auto',
			'output'    => array(
				array(
					'element' => 'h6, .h6',
				),
			),
		);

		return $this;
	}

	/**
	 * Color controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function colors() {
		$this->controls[] = array(
			'settings'  => 'mfit_text_color',
			'label'     => esc_html__( 'Text Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 10,
			'default'   => '#242545',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'mfit_primary_color',
			'label'     => esc_html__( 'Primary Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 15,
			'default'   => '#738ff4',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'mfit_secondary_color',
			'label'     => esc_html__( 'Secondary Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 20,
			'default'   => '#fc346c',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'mfit_tertiary_color',
			'label'     => esc_html__( 'Tertiary Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 25,
			'default'   => '#fccc6c',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'mfit_offset_color',
			'label'     => esc_html__( 'Offset Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 30,
			'default'   => '#EFF5FC',
			'transport' => 'postMessage',
		);

		$this->controls[] = array(
			'settings'  => 'mfit_border_color',
			'label'     => esc_html__( 'Border Color', 'maxx-fitness' ),
			'section'   => 'mfit_color_settings',
			'type'      => 'color',
			'priority'  => 35,
			'default'   => '#DDDDDD',
			'transport' => 'postMessage',
		);

		return $this;
	}

	/**
	 * Page controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function page() {
		$this->controls[] = array(
			'type'         => 'repeater',
			'settings'     => 'mfit_home_top_slider',
			'label'        => esc_html__( 'Showcase Slider', 'maxx-fitness' ),
			'section'      => 'mfit_showcase_slider',
			'priority'     => 10,
			'row_label'    => array(
				'type'  => 'text',
				'value' => esc_html__( 'Slides', 'maxx-fitness' ),
			),
			'button_label' => esc_html__( 'Add More', 'maxx-fitness' ),
			'fields'       => array(
				'slide_image'  => array(
					'type'        => 'image',
					'label'       => esc_html__( 'Upload Slide Image', 'maxx-fitness' ),
					'description' => esc_html__( 'Please upload slide image. Recommended image size is 1920x1080 px.', 'maxx-fitness' ),
				),
				// 'promo_title' => array(
				// 	'type'        => 'text',
				// 	'label'       => esc_html__( 'Promo Text', 'maxx-fitness' ),
				// 	'description' => esc_html__( 'Please enter the slide promo text', 'maxx-fitness' ),
				// ),
				'title' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Slide Title', 'maxx-fitness' ),
					'description' => esc_html__( 'Please enter the slide title text', 'maxx-fitness' ),
				),
				'subtitle' => array(
					'type'        => 'textarea',
					'label'       => esc_html__( 'Slide Description', 'maxx-fitness' ),
					'description' => esc_html__( 'Please enter the slide description text', 'maxx-fitness' ),
				),
				'link' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Slide URL', 'maxx-fitness' ),
					'description' => esc_html__( 'Please enter the slide link', 'maxx-fitness' ),
				),
			),
		);

		$this->controls[] = array(
			'type'        => 'background',
			'settings'    => 'mfit_pagetitle_banner_bg',
			'label'       => esc_html__( 'Page title Banner Background', 'maxx-fitness' ),
			'description' => esc_html__( 'Please upload page title banner image. Recommended image size is 1920x1080 px.', 'maxx-fitness' ),
			'section'     => 'mfit_pagetitle',
			'priority'    => 10,
			'default'     => array(
				'background-image'      => '',
				'background-repeat'     => 'no-repeat',
				'background-position'   => 'left top',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'settings'    => 'mfit_pagetitle_padding',
			'label'       => esc_html__( 'Page Title Banner Padding', 'maxx-fitness' ),
			'description' => esc_html__( 'Page title banner top/bottom padding. Default: 8rem.', 'maxx-fitness' ),
			'section'     => 'mfit_pagetitle',
			'type'        => 'dimensions',
			'priority'    => 15,
			'default'     => array(
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'maxx-fitness' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'maxx-fitness' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => '#page-title',
				),
			),
		);

		$this->controls[] = array(
			'type'        => 'text',
			'settings'    => 'mfit_pagetitle_blog',
			'label'       => esc_html__( 'Page title Text for Blog', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter the page title text for blog.', 'maxx-fitness' ),
			'section'     => 'mfit_pagetitle',
			'priority'    => 25,
			'transport'   => 'auto',
			'default'     => esc_html__( 'blog', 'maxx-fitness' ),
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'mfit_enable_breadcrumbs',
			'label'       => esc_html__( 'Enable Breadcrumbs?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable breadcrumbs.', 'maxx-fitness' ),
			'section'     => 'mfit_breadcrumbs',
			'default'     => 0,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_page_padding',
			'label'       => esc_html__( 'Page Padding', 'maxx-fitness' ),
			'description' => esc_html__( 'Page top/bottom padding. Default: 8rem.', 'maxx-fitness' ),
			'section'     => 'mfit_page_styles',
			'type'        => 'dimensions',
			'priority'    => 10,
			'default'     => array(
				'padding-top'    => '8rem',
				'padding-bottom' => '8rem',
			),
			'choices'     => array(
				'labels' => array(
					'padding-top'    => esc_html__( 'Padding Top', 'maxx-fitness' ),
					'padding-bottom' => esc_html__( 'Padding Bottom', 'maxx-fitness' ),
				),
			),
			'transport'   => 'auto',
			'output'      => array(
				array(
					'element' => 'body:not(.woocommerce-page.archive) #wrapper.inner-page-content',
				),
			),
		);

		return $this;
	}

	/**
	 * Blog controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function blog() {
		$this->controls[] = array(
			'settings'    => 'mfit_archive_description',
			'label'       => esc_html__( 'Archive Description', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter archive description.', 'maxx-fitness' ),
			'section'     => 'mfit_archive_settings',
			'type'        => 'textarea',
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_archive_pagination',
			'label'       => esc_html__( 'Pagination Type', 'maxx-fitness' ),
			'description' => esc_html__( 'Please select the pagination type for archive pages', 'maxx-fitness' ),
			'choices'     => array(
				'classic'  => esc_html__( 'Classic Pagination', 'maxx-fitness' ),
				'numbered' => esc_html__( 'Numbered Pagination', 'maxx-fitness' ),
			),
			'type'        => 'select',
			'section'     => 'mfit_archive_settings',
			'priority'    => 11,
			'default'     => 'classic',
		);

		// $this->controls[] = array(
		// 	'settings'    => 'mfit_single_pagination',
		// 	'label'       => esc_html__( 'Enable Single Post Navigation?', 'maxx-fitness' ),
		// 	'description' => esc_html__( 'Enable/disable single post navigation', 'maxx-fitness' ),
		// 	'type'        => 'toggle',
		// 	'section'     => 'mfit_single_settings',
		// 	'priority'    => 10,
		// 	'default'     => 0,
		// );

		return $this;
	}

	/**
	 * Social Media controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function socials() {
		$this->controls[] = array(
			'type'         => 'repeater',
			'settings'     => 'mfit_social_media_profiles',
			'label'        => esc_html__( 'Social Media Information', 'maxx-fitness' ),
			'section'      => 'mfit_social_media',
			'priority'     => 10,
			'row_label'    => array(
				'type'  => 'text',
				'value' => esc_html__( 'Social Profile', 'maxx-fitness' ),
			),
			'button_label' => esc_html__( 'Add More', 'maxx-fitness' ),
			'fields'       => array(
				'type_image'  => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Icon Class', 'maxx-fitness' ),
					'description' => esc_html__( 'Please enter Font Awesome or other icon class', 'maxx-fitness' ),
				),
				'profile_url' => array(
					'type'        => 'link',
					'label'       => esc_html__( 'Profile Link', 'maxx-fitness' ),
					'description' => esc_html__( 'Please enter the social media profile link', 'maxx-fitness' ),
				),
			),
		);

		return $this;
	}

	/**
	 * Integration controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function integrations() {
		$this->controls[] = array(
			'settings'    => 'mfit_header_code',
			'label'       => esc_html__( 'Header Code', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter the header code (Wrap this code with &lt;script&gt; tag).', 'maxx-fitness' ),
			'type'        => 'code',
			'section'     => 'mfit_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 10,
		);

		$this->controls[] = array(
			'settings'    => 'mfit_footer_code',
			'label'       => esc_html__( 'Footer Code', 'maxx-fitness' ),
			'description' => esc_html__( 'Please enter the footer code (Wrap this code with &lt;script&gt; tag).', 'maxx-fitness' ),
			'type'        => 'code',
			'section'     => 'mfit_integrations',
			'choices'     => array(
				'language' => 'html',
			),
			'priority'    => 15,
		);

		return $this;
	}

	/**
	 * Extra controls.
	 *
	 * @access private
	 * @return object
	 *
	 * @since 1.0.0
	 */
	private function extras() {
		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'mfit_enable_totop',
			'label'       => esc_html__( 'Enable Scroll To-Top Button?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable scroll to top button.', 'maxx-fitness' ),
			'section'     => 'mfit_extra_settings',
			'default'     => 1,
			'priority'    => 10,
		);

		$this->controls[] = array(
			'type'        => 'toggle',
			'settings'    => 'mfit_enable_pageloader',
			'label'       => esc_html__( 'Enable Page Loader?', 'maxx-fitness' ),
			'description' => esc_html__( 'Enable/disable page loader animation.', 'maxx-fitness' ),
			'section'     => 'mfit_extra_settings',
			'default'     => 1,
			'priority'    => 15,
		);

		return $this;
	}
}
