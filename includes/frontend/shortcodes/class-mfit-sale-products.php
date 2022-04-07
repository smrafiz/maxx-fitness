<?php
/**
 * Sale Products Shortcode Class.
 *
 * This class renders on sale products in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Sale Products Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Sale_Products {

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
	 * @return Mfit_Social_Icons
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
		add_shortcode( 'mfit_sale_products', array( $this, 'shortcode' ) );
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
				'limit' => '20',
				'start' => current_time( 'Ymd' ),
				'end'   => current_time( 'Ymd' ),
			),
			$atts
		);
		$result = '';

		global $woocommerce_loop, $woocommerce;

		// Get products on sale
		$product_ids_on_sale = woocommerce_get_product_ids_on_sale();

		// echo '<pre>';
		// print_r( $woocommerce );
		// echo '</pre>';

		$meta_query   = array();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
		$meta_query[] = $woocommerce->query->stock_status_meta_query();

		$args = array(
			'posts_per_page' => -1,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'orderby'        => 'date',
			'order'          => 'ASC',
			'meta_query'     => $meta_query,
			'post__in'       => $product_ids_on_sale,
		);

		ob_start();

		$products = new WP_Query( $args );

		if ( $products->have_posts() ) { ?>

			<?php woocommerce_product_loop_start(); ?>

				<?php
				while ( $products->have_posts() ) :
					$products->the_post();
					?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php
			woocommerce_product_loop_end();

		} else {
			do_action( 'woocommerce_shortcode_products_loop_no_results', $atts );
			echo '<p>There is no results.</p>';
		}

		woocommerce_reset_loop();
		wp_reset_postdata();

		$result .= '<div class="mfit-sale-products">' . ob_get_clean() . '</div>';

		return $result;
	}
}
