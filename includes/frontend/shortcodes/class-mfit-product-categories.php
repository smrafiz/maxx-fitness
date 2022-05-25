<?php
/**
 * Product Categories Shortcode Class.
 *
 * This class renders social icons in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Product Categories Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Product_Categories {

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
		add_shortcode( 'mfit_product_categories', array( $this, 'shortcode' ) );
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

		$page   = get_queried_object();
		$parent = '';

		if ( ! is_shop() ) {
			$parent = $page->term_id;
		}

		if ( Mfit_Helpers::inside_top_product_cat() && ! Mfit_Helpers::inside_product_attribute() ) {

			$args = array(
				'parent' => $parent,
			);

			$page_terms = get_terms( 'product_cat', $args );

			if ( 'zubehor' !== $page->slug ) {
				$this->render_accordion( $parent, $page_terms );
			}
		} elseif ( Mfit_Helpers::inside_product_cat() ) {
			$parent = $page->parent;
			$args   = array(
				'parent' => $parent,
			);

			$page_terms = get_terms( 'product_cat', $args );
			$this->render_accordion( $parent, $page_terms, $page );
		}

		$other_cat_args = array(
			'orderby' => 'name',
			'order'   => 'ASC',
			'parent'  => 0,
			'exclude' => $parent,
		);

		$other_terms = get_terms( 'product_cat', $other_cat_args );

		foreach ( $other_terms as $other_term ) {
			if ( ! ( 'ausdauertraining' === $other_term->slug || 'trainingszirkel' === $other_term->slug || 'krafttraining' === $other_term->slug ) ) {
				continue;
			}

			$child_args = array(
				'orderby' => 'name',
				'order'   => 'ASC',
				'parent'  => $other_term->term_id,
			);

			$child_terms = get_terms( 'product_cat', $child_args );

			$this->render_accordion( $other_term->term_id, $child_terms );
		}

		$result .= ob_get_clean();

		return $result;
	}

	/**
	 * Render Accordion
	 *
	 * @param int    $parent Parent ID.
	 * @param object $children Child terms.
	 * @param object $page Page.
	 * @return void
	 */
	private function render_accordion( $parent, $children, $page = null ) {
		?>
		<div class="mfit-product-categories sidebar-accordion">
			<h4 class="widgettitle accordion-toggle">
				<?php
				echo esc_html( get_the_category_by_ID( $parent ) );
				?>
			</h4>
			<ul class="accordion-content">
				<?php
				foreach ( $children as $child ) {
					$class = $page && $page->term_id === $child->term_id ? 'current-term' : '';

					echo '<li class="' . esc_attr( $class ) . '">';
						echo '<a href="' . esc_url( get_term_link( $child ) ) . '" class="mfit-text primary ' . esc_attr( $child->slug ) . '">';
							echo esc_html( $child->name );
						echo '</a>';
					echo '</li>';
				}
				?>
			</ul>
		</div>
		<?php
	}
}
