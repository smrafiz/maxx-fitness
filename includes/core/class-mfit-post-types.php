<?php
/**
 * Custom Post Types initiator.
 *
 * This class registers custom post types required for Mfit Theme.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Custom Post Type Controller Class.
 *
 * @since  1.0.0
 */
class Mfit_Post_Types {

	/**
	 * Accumulates Custom Post Types.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var array
	 */
	public $custom_post_types = array();

	/**
	 * Accumulates Custom Taxonomies.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var array
	 */
	public $custom_taxonomies = array();

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
	 *
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Mfit_Post_Types
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to register CPT.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		$this->define_post_types();
		$this->define_tax();

		if ( ! empty( $this->custom_post_types ) ) {
			$this->register_custom_post_types();
		}

		if ( ! empty( $this->custom_taxonomies ) ) {
			$this->register_custom_taxonomies();
		}
	}

	/**
	 * Method to define Post Types.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @return array
	 */
	private function define_post_types() {
		$this->custom_post_types = array(
			// array(
			// 	'name'   => __( 'Gallery', 'maxx-fitness' ),
			// 	'slug'   => 'mfit_gallery',
			// 	'labels' => array(
			// 		'all_items' => __( 'All Galleries', 'maxx-fitness' ),
			// 	),
			// 	'args'   => array(
			// 		'menu_icon'          => 'dashicons-format-gallery',
			// 		'publicly_queryable' => false,
			// 		'has_archive'        => false,
			// 		'supports'           => array(
			// 			'title',
			// 		),
			// 	),
			// ),

			// array(
			// 	'name'   => __( 'Testimonials', 'maxx-fitness' ),
			// 	'slug'   => 'mfit_testimonial',
			// 	'labels' => array(
			// 		'all_items' => __( 'All Testimonials', 'maxx-fitness' ),
			// 	),
			// 	'args'   => array(
			// 		'publicly_queryable' => false,
			// 		'has_archive'        => false,
			// 		'supports'           => array(
			// 			'title',
			// 			'thumbnail',
			// 		),
			// 	),
			// ),
		);

		return $this->custom_post_types;
	}

	/**
	 * Method to define Taxonomies.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @return array
	 */
	private function define_tax() {
		$this->custom_taxonomies = array(
			array(
				'name'     => __( 'Gallery Type', 'maxx-fitness' ),
				'cpt_name' => array( 'mfit_gallery' ),
				'slug'     => 'mfit_gallery_type',
				'labels'   => array(
					'menu_name' => __( 'Types', 'maxx-fitness' ),
				),
				'args'     => array(
					'hierarchical' => true,
					'rewrite'      => array(
						'slug' => 'type',
					),
				),
			),
		);

		return $this->custom_taxonomies;
	}

	/**
	 * Method to loop through all the CPT definitions and build up CPT.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_custom_post_types() {
		foreach ( $this->custom_post_types as $post_type ) {
			new Mfit_Custom_Post_Type(
				$post_type['name'],
				$post_type['slug'],
				! empty( $post_type['labels'] ) ? $post_type['labels'] : array(),
				! empty( $post_type['args'] ) ? $post_type['args'] : array()
			);
		}
	}

	/**
	 * Method to loop through all the Tax definitions and build up Taxonomies.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_custom_taxonomies() {
		foreach ( $this->custom_taxonomies as $custom_tax ) {
			new Mfit_Custom_Taxonomy(
				$custom_tax['name'],
				$custom_tax['cpt_name'],
				$custom_tax['slug'],
				! empty( $custom_tax['labels'] ) ? $custom_tax['labels'] : array(),
				! empty( $custom_tax['args'] ) ? $custom_tax['args'] : array()
			);
		}
	}
}
