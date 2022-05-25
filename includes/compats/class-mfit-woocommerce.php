<?php
/**
 * Woocommerce Compatibility Class.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Woocommerce Class.
 */
class Mfit_Woocommerce {

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
	 * @return Mfit_Woocommerce
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Registering Woocommerce Support.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function register() {

		// Setup Woocommerce.
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		// WooCommerce specific scripts & stylesheets.
		add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_scripts' ) );

		// Disabling the default WooCommerce stylesheet.
		// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

		// Shop hide default page title.
		add_filter( 'woocommerce_show_page_title', '__return_false' );

		// Removing breadcrumbs.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

		// Header cart count number.
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'header_cart_count' ) );

		// Related Products Args.
		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products' ) );

		// Removing default WooCommerce wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Adding wrapper according to theme structure.
		add_action( 'woocommerce_before_main_content', array( $this, 'wrapper_before' ) );
		add_action( 'woocommerce_after_main_content', array( $this, 'wrapper_after' ) );

		// Custom mini cart.
		add_action( 'wp_head', array( $this, 'custom_cart_functionality' ) );

		// Product thumb & title.
		remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
		remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
		add_action( 'woocommerce_before_subcategory_title', array( $this, 'image_wrapper' ) );
		add_action( 'woocommerce_shop_loop_subcategory_title', array( $this, 'custom_title' ) );

		// Shop top bar.
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_topbar' ), 10 );

		// Removing some hooked woocommerce functions.
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

		// Custom on-sale.
		add_filter( 'woocommerce_sale_flash', array( $this, 'sale_flash' ), 10, 3 );

		// Custom price text.
		add_filter( 'woocommerce_get_price_html', array( $this, 'product_price_display' ) );

		// Custom product query.
		add_action( 'woocommerce_product_query', array( $this, 'product_query' ) );

		// Custom sorting.
		add_filter( 'woocommerce_catalog_orderby', array( $this, 'sorting_orderby' ) );

		// Default Sorting.
		add_filter( 'woocommerce_default_catalog_orderby', array( $this, 'default_catalog_orderby' ) );

		// Product Custom Tabs.
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_tabs' ) );

		// Single product summary.
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 22 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'product_information' ), 21, 0 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		add_action( 'woocommerce_single_product_summary', array( $this, 'payment_logo' ), 41, 0 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'contact_section' ), 8, 0 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'tab_title' ), 9, 0 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_gzd_template_single_legal_info', 12 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_gzd_template_single_legal_info', 29 );
		remove_action( 'template_redirect', 'wc_track_product_view', 20 );
		add_action( 'template_redirect', array( $this, 'track_product_view' ), 20 );
		add_action( 'woocommerce_product_options_inventory_product_data', array( $this, 'add_min_quantity' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_min_quantity_field' ) );
		add_filter( 'woocommerce_quantity_input_args', array( $this, 'wc_qty_input_args' ), 10, 2 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'add_to_cart_validation' ), 1, 5 );

		// Cart Page.
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart_form', 'woocommerce_cross_sell_display' );

		// My Account Page.
		add_filter( 'woocommerce_account_menu_items', array( $this, 'my_account_links' ) );
		add_filter( 'woocommerce_get_endpoint_url', array( $this, 'my_account_custom_links' ), 10, 4 );

		/* Yith Wishlist */
		if ( function_exists( 'YITH_WCWL_Frontend' ) && class_exists( 'YITH_WCWL_Ajax_Handler' ) ) {

			$wishlist_init = YITH_WCWL_Frontend();

			remove_action( 'wp_head', array( $wishlist_init, 'add_button' ) );
			add_action( 'wp_ajax_mfit_add_to_wishlist', array( $this, 'add_to_wishlist' ) );
			add_action( 'wp_ajax_nopriv_mfit_add_to_wishlist', array( $this, 'add_to_wishlist' ) );

			add_action( 'wp_ajax_mfit_remove_from_wishlist', array( $this, 'remove_from_wishlist' ) );
			add_action( 'wp_ajax_nopriv_mfit_remove_from_wishlist', array( $this, 'remove_from_wishlist' ) );

			add_filter( 'yith_wcwl_show_add_to_wishlist', '__return_false' );
		}
	}

	/**
	 * Setup Woocommerce.
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
	 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function setup() {
		add_theme_support(
			'woocommerce',
			array(
				'thumbnail_image_width' => 400,
				'single_image_width'    => 600,
				'product_grid'          => array(
					'default_rows'    => 3,
					'min_rows'        => 1,
					'default_columns' => 3,
					'min_columns'     => 1,
					'max_columns'     => 6,
				),
			)
		);
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function woocommerce_scripts() {
		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		$inline_font = '@font-face {
                font-family: "star";
                src: url("' . $font_path . 'star.eot");
                src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                    url("' . $font_path . 'star.woff") format("woff"),
                    url("' . $font_path . 'star.ttf") format("truetype"),
                    url("' . $font_path . 'star.svg#star") format("svg");
                font-weight: normal;
                font-style: normal;
            }';

		wp_add_inline_style( 'mfit-stylesheet', $inline_font );
	}

	/**
	 * Related Products Args.
	 *
	 * @access public
	 * @param array $args related products args.
	 * @return array $args related products args.
	 *
	 * @since 1.0.0
	 */
	public function related_products( $args ) {
		$defaults = array(
			'posts_per_page' => 3,
			'columns'        => 3,
		);

		$args = wp_parse_args( $defaults, $args );

		return $args;
	}

	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function wrapper_before() {
		?>
		<div id="content" class="content-area">
			<div class="container">
				<div class="row">
				<?php
				if ( Mfit_Helpers::inside_shop() || Mfit_Helpers::inside_product_cat() || Mfit_Helpers::inside_product_attribute() ) {
					echo '<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-3 mfit-shop-sidebar">';
						echo '<aside id="secondary" class="widget-area">';
							get_sidebar();
						echo '</aside><!-- #secondary -->';
					echo '</div>';
					echo '<div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 mfit-shop-content">';
				} else {
					echo '<div class="col-12 col-sm-12 col-md-12">';
				}
				?>
						<main id="primary" class="site-main">
			<?php
	}

	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @access public
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function wrapper_after() {
		?>
						</main><!-- #main -->
					</div>
				</div>
			</div>
		</div><!-- #content -->
		<?php
	}

	/**
	 * Woocommerce cart count
	 *
	 * @param array $fragments Cart fragments.
	 * @return array
	 */
	public function header_cart_count( $fragments ) {
		$number                           = '<span class="cart-icon-num">' . WC()->cart->get_cart_contents_count() . '</span>';
		$total                            = '<div class="cart-icon-total">' . WC()->cart->get_cart_total() . '</div>';
		$fragments['span.cart-icon-num']  = $number;
		$fragments['div.cart-icon-total'] = $total;
		return $fragments;
	}

	/**
	 * Custom cart
	 *
	 * @return void
	 */
	public function custom_cart_functionality() {
		add_filter( 'woocommerce_widget_cart_is_hidden', '__return_true' );
		?>
		<div class="drawer-container">
			<span class="close">
				<i class="fa fa-1x fa-angle-right"></i>
			</span>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div id="side-content-area-id"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="drawer-overlay"></div>
		<?php
	}

	/**
	 * Show subcategory thumbnails.
	 *
	 * @param mixed $category Category.
	 * @return void
	 */
	public function image_wrapper( $category ) {
		if ( 0 === $category->parent ) {
			return;
		}

		$small_thumbnail_size = 'full';
		$dimensions           = wc_get_image_size( $small_thumbnail_size );
		$thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );

		if ( $thumbnail_id ) {
			$image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
			$image        = $image[0];
			$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
			$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
		} else {
			$image        = wc_placeholder_img_src();
			$image_srcset = false;
			$image_sizes  = false;
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds.
			// Ref: https://core.trac.wordpress.org/ticket/23605.
			$image = str_replace( ' ', '%20', $image );

			// Add responsive image markup if available.
			echo '<div class="mfit-image-box elementor-widget-image-box">';
			echo '<div class="elementor-image-box-wrapper">';
			echo '<div class="elementor-image-box-img">';

			if ( $image_srcset && $image_sizes ) {
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
			} else {
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
			}

			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}

	/**
	 * Show the subcategory title in the product loop.
	 *
	 * @param mixed $category Category.
	 * @return void
	 */
	public function custom_title( $category ) {
		if ( 0 === $category->parent ) {
			return;
		}
		?>
		<div class="mfit-category-title">
			<h2 class="woocommerce-loop-category__title h5">
				<?php
				$parent = get_term_by( 'id', $category->parent, 'product_cat' );

				if ( 'krafttraining' === $parent->slug ) {
					$category->name = esc_html( $parent->name ) . ' für <br>' . esc_html( $category->name );
				}

				if ( 'trainingszirkel' === $parent->slug ) {
					$category->name = esc_html( $parent->name ) . ' <br>' . esc_html( $category->name );
				}

				echo $category->name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</h2>
		</div>
		<?php
	}

	/**
	 * Get shot topbar.
	 *
	 * @return void
	 */
	public function shop_topbar() {
		Mfit_Helpers::get_custom_template_part( 'shop-topbar' );
	}

	/*
	*  Single product: Get sale percentage
	*/
	/**
	 * Single product: Get sale percentage
	 *
	 * @param array  $args Product args.
	 * @param int    $post Post ID.
	 * @param object $product Product.
	 * @return string
	 */
	public function sale_flash( $args, $post, $product ) {
		if ( $product->get_type() === 'variable' ) {
			// Get product variation prices.
			$product_variation_prices = $product->get_variation_prices();

			$highest_sale_percent = 0;

			foreach ( $product_variation_prices['regular_price'] as $key => $regular_price ) {
				// Get sale price.
				$sale_price = $product_variation_prices['sale_price'][ $key ];

				// Is product variation on sale.
				if ( $sale_price < $regular_price ) {
					$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

					// Is current sale percent highest.
					if ( $sale_percent > $highest_sale_percent ) {
						$highest_sale_percent = $sale_percent;
					}
				}
			}

			// Return variation sale percent.
			return sprintf( '<span class="onsale">-%s%%</span>', $highest_sale_percent );

		} else {
			$regular_price = $product->get_regular_price();
			$sale_percent  = 0;

			// Make sure calculated.
			if ( intval( $regular_price ) > 0 ) {
				$sale_percent = round( ( ( $regular_price - $product->get_sale_price() ) / $regular_price ) * 100 );
			}

			return sprintf( '<span class="onsale">-%s%%</span>', $sale_percent );
		}
	}

	/**
	 * Custom rating.
	 *
	 * @return void
	 */
	public function custom_rating() {
		global $product;
		$rating = $product->get_average_rating();

		$rating_html = '</a><a href="' . get_the_permalink() . '#respond"><div class="star-rating ehi-star-rating"><span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"></span></div></a>';

		echo $rating_html;

		// Now we display the product short description. This is optional.
		wc_get_template( 'single-product/short-description.php' );
	}

	/**
	 * Price prefix text.
	 *
	 * @param string $price Product price.
	 * @return string
	 */
	public function product_price_display( $price ) {
		if ( is_admin() ) {
			return $price;
		}

		$text = esc_html__( ' Jetzt Nur', 'maxx-fitness' );
		return str_replace( '<ins>', '<ins><span>' . $text . '</span>', $price );
	}

	/**
	 * Add to wishlist.
	 *
	 * @return void
	 */
	public function add_to_wishlist() {
		check_ajax_referer( 'add_to_wishlist', 'nonce' );
		YITH_WCWL()->add();
		wp_die();
	}

	/**
	 * Remove from wishlist.
	 *
	 * @return void
	 */
	public function remove_from_wishlist() {
		check_ajax_referer( 'add_to_wishlist', 'nonce' );
		YITH_WCWL()->remove();
		wp_die();
	}

	/**
	 * Custom product query
	 *
	 * @param object $q Query object.
	 * @return void
	 */
	public function product_query( $q ) {
		if ( ! ( isset( $_GET['orderby'] ) || isset( $_GET['show_term'] ) ) ) {
			return;
		}

		if ( isset( $_GET['orderby'] ) && 'onsale' === $_GET['orderby'] ) {
			$sale_ids = wc_get_product_ids_on_sale();

			if ( is_array( $sale_ids ) && ! empty( $sale_ids ) ) {
				foreach ( $sale_ids as $sale_id ) {
					$regular_price = get_post_meta( $sale_id, '_regular_price', true );
					$sale_price    = get_post_meta( $sale_id, '_sale_price', true );

					$sale_percent = 0;

					if ( intval( $regular_price ) > 0 ) {
						$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
					}

					$sale[ $sale_id ] = absint( $sale_percent );
				}

				arsort( $sale );

				$post_in = array_keys( $sale );

				$q->set( 'post__in', $post_in );
				$q->set( 'orderby', 'post__in' );
			}
		}

		if ( isset( $_GET['orderby'] ) && 'bestseller' === $_GET['orderby'] ) {
			$q->set( 'meta_key', 'total_sales' );
			$q->set(
				'orderby',
				array(
					'meta_value_num' => 'DESC',
					'title'          => 'ASC',
				)
			);
		}

		if ( isset( $_GET['show_term'] ) && 'marken' === $_GET['show_term'] ) {
			$term_ids = Mfit_Helpers::get_all_attribute_terms( 'pa_marken' );

			$q->set(
				'tax_query',
				array(
					array(
						'taxonomy' => 'pa_marken',
						'field'    => 'term_id',
						'terms'    => $term_ids,
						'operator' => 'IN',
					),
				)
			);
		}

		if ( isset( $_GET['show_term'] ) && 'pedalo' === $_GET['show_term'] ) {
			$term_ids = Mfit_Helpers::get_all_attribute_terms( 'pa_pedalo' );

			$q->set(
				'tax_query',
				array(
					array(
						'taxonomy' => 'pa_pedalo',
						'field'    => 'term_id',
						'terms'    => $term_ids,
						'operator' => 'IN',
					),
				)
			);
		}

		if ( isset( $_GET['show_term'] ) && 'smartcircle' === $_GET['show_term'] ) {
			$term_ids = Mfit_Helpers::get_all_attribute_terms( 'pa_smartcircle' );

			$q->set(
				'tax_query',
				array(
					array(
						'taxonomy' => 'pa_smartcircle',
						'field'    => 'term_id',
						'terms'    => $term_ids,
						'operator' => 'IN',
					),
				)
			);
		}
	}

	/**
	 * Custom Sorting.
	 *
	 * @return array
	 */
	public function sorting_orderby() {
		return array(
			'price'      => __( 'Preis aufsteigend', 'maxx-fitness' ),
			'price-desc' => __( 'Preis absteigend', 'maxx-fitness' ),
			'onsale'     => __( 'Sale', 'maxx-fitness' ),
			'rating'     => __( 'Empfehlung', 'maxx-fitness' ),
			'bestseller' => __( 'Bestseller', 'maxx-fitness' ),
		);
	}

	/**
	 * Default Sorting.
	 *
	 * @param string $sort_by Sort order.
	 * @return string
	 */
	public function default_catalog_orderby( $sort_by ) {
		return 'price';
	}

	/**
	 * Product Custom Tabs
	 *
	 * @param array $tabs Product tabs.
	 * @return array
	 */
	public function product_tabs( $tabs ) {
		unset( $tabs['additional_information'] );

		if ( get_field( 'mfit_enable_specifications' ) ) {
			$tabs['technical_data'] = array(
				'title'    => __( 'Technische Daten', 'maxx-fitness' ),
				'priority' => 20,
				'callback' => array( $this, 'technical_data_tab_content' ),
			);
		}

		if ( get_field( 'mfit_enable_accessories' ) ) {
			$tabs['accessories'] = array(
				'title'    => __( 'Zubehör', 'maxx-fitness' ),
				'priority' => 21,
				'callback' => array( $this, 'accessories_tab_content' ),
			);
		}

		if ( get_field( 'mfit_enable_video' ) ) {
			$tabs['video'] = array(
				'title'    => __( 'Videos', 'maxx-fitness' ),
				'priority' => 22,
				'callback' => array( $this, 'video_tab_content' ),
			);
		}

		return $tabs;
	}

	/**
	 * Technical Data Tab Content.
	 *
	 * @return void
	 */
	public function technical_data_tab_content() {
		wc_get_template( 'single-product/tabs/technical-data.php' );
	}

	/**
	 * Accessories Tab Content.
	 *
	 * @return void
	 */
	public function accessories_tab_content() {
		wc_get_template( 'single-product/tabs/accessories.php' );
	}

	/**
	 * Video Tab Content.
	 *
	 * @return void
	 */
	public function video_tab_content() {
		wc_get_template( 'single-product/tabs/videos.php' );
	}

	/**
	 * Product information.
	 *
	 * @return void
	 */
	public function product_information() {
		$type = get_field( 'mfit_product_typnr' );
		$item = get_field( 'mfit_product_artikelnummer' );
		$ean  = get_field( 'mfit_product_ean_gtin' );

		if ( empty( $type ) && empty( $item ) && empty( $ean ) ) {
			return;
		}

		echo '<div class="product-info">';
		echo '<div class="product-info-inner">';

		if ( ! empty( $type ) ) {
			echo '<div class="info-item-wrapper">';
			echo '<div class="info-item-title">Typnr:</div>';
			echo '<div class="info-item">' . $type . '</div>';
			echo '</div>';
		}

		if ( ! empty( $item ) ) {
			echo '<div class="info-item-wrapper">';
			echo '<div class="info-item-title">Artikelnummer:</div>';
			echo '<div class="info-item">' . $item . '</div>';
			echo '</div>';
		}

		if ( ! empty( $ean ) ) {
			echo '<div class="info-item-wrapper">';
			echo '<div class="info-item-title">EAN / GTIN Number:</div>';
			echo '<div class="info-item">' . $ean . '</div>';
			echo '</div>';
		}

		echo '</div>';
		echo '</div>';

		echo '<div class="product-wishlist">';
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		echo '</div>';
	}

	/**
	 * Payment Logo.
	 *
	 * @return void
	 */
	public function payment_logo() {
		$logos = array(
			'paypal.svg',
			'paypal-r.svg',
			'mastercard.svg',
			'sepa.png',
			'amex.png',
			'visa.svg',
		);
		?>
		<div class="payment-logo-wrap">
			<ul class="mb-0 list-inline">
				<?php
				foreach ( $logos as $logo ) {
					echo '<li class="list-inline-item"><img width="200" height="50" src="' . esc_url( get_template_directory_uri() . '/assets/images/' . $logo ) . '" alt="Footer Payment Logo"></li>';
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Contact Section
	 *
	 * @return void
	 */
	public function contact_section() {
		$title       = get_field( 'mfit_cta_title' );
		$button_text = get_field( 'mfit_cta_button_text' );
		$button_link = get_field( 'mfit_cta_button_link' );

		if ( empty( $title ) && empty( $button_text ) && empty( $button_link ) ) {
			return;
		}
		?>
		<div class="single-contact-section text-center mb-full bgc-offset pos-r">
			<h2 class="h3"><?php echo $title; ?></h2>
			<div class="contact-button">
				<a href="<?php echo $button_link; ?>" class="mfit-btn primary"><?php echo $button_text; ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Tab Title
	 *
	 * @return void
	 */
	public function tab_title() {
		global $product;

		echo '<div class="tab-title">';
		echo '<div class="section-title"><h2>Produktinformationen ' . $product->get_name() . '</h2></div>';
		echo '</div>';
	}

	/**
	 * My Account Links.
	 *
	 * @return array
	 */
	public function my_account_links() {
		return array(
			// 'dashboard'                => esc_html__( 'Dashboard', 'maxx-fitness' ),
			'edit-account'     => esc_html__( 'Anmelden & Sicherheit', 'maxx-fitness' ),
			'orders'           => esc_html__( 'Meine Bestellungen', 'maxx-fitness' ),
			'edit-address'     => esc_html__( 'Adressen', 'maxx-fitness' ),
			'recently-viewed'  => esc_html__( 'Kürzlich angesehen', 'maxx-fitness' ),
			'kontakt-formular' => esc_html__( 'Hilfe', 'maxx-fitness' ),
			'customer-logout'  => esc_html__( 'Abmelden', 'maxx-fitness' ),
		);
	}

	/**
	 * My Account Custom Links
	 *
	 * @param string $url Tab URL.
	 * @param string $endpoint WooCommerce endpoint.
	 * @param string $value Value.
	 * @param string $permalink Permalink.
	 * @return string
	 */
	public function my_account_custom_links( $url, $endpoint, $value, $permalink ) {
		if ( 'kontakt-formular' === $endpoint ) {
			$url = site_url() . '/service-formular';
		}

		if ( 'recently-viewed' === $endpoint ) {
			$url = site_url() . '/recently-viewed-products';
		}

		return $url;
	}

	/**
	 * Track product view.
	 *
	 * @return void
	 */
	public function track_product_view() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}

		global $post;

		if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
			$viewed_products = array();
		} else {
			$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) );
		}

		// Unset if already in viewed products list.
		$keys = array_flip( $viewed_products );

		if ( isset( $keys[ $post->ID ] ) ) {
			unset( $viewed_products[ $keys[ $post->ID ] ] );
		}

		$viewed_products[] = $post->ID;

		if ( count( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}

		// Store for session only.
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
	}

	/**
	 * Adds a new field in products page.
	 *
	 * @return void
	 */
	public function add_min_quantity() {
		echo '<div class="options_group">';
		woocommerce_wp_text_input(
			array(
				'id'          => '_wc_min_qty_product',
				'label'       => __( 'Minimum Quantity', 'maxx-fitness' ),
				'placeholder' => '',
				'desc_tip'    => 'true',
				'description' => __( 'Optional. Set a minimum quantity limit allowed per order. Enter a number, 1 or greater.', 'maxx-fitness' ),
			)
		);
		echo '</div>';
	}

	/**
	 * Saves Minimum Quantity Option.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function save_min_quantity_field( $post_id ) {
		$val_min = trim( get_post_meta( $post_id, '_wc_min_qty_product', true ) );
		$new_min = sanitize_text_field( $_POST['_wc_min_qty_product'] );

		if ( $val_min != $new_min ) {
			update_post_meta( $post_id, '_wc_min_qty_product', $new_min );
		}
	}

	/*
	* Setting minimum and maximum for quantity input args.
	*/
	/**
	 * Setting minimum for quantity input args.
	 *
	 * @param array  $args Product args.
	 * @param object $product Product object.
	 * @return array
	 */
	public function wc_qty_input_args( $args, $product ) {

		$product_id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();

		$product_min = $this->get_product_min_limit( $product_id );

		if ( ! empty( $product_min ) ) {
			if ( false !== $product_min ) {
				$args['min_value'] = $product_min;
			}
		}

		return $args;
	}

	/**
	 * Validating the quantity on add to cart action with the quantity of the
	 * same product available in the cart.
	 *
	 * @param int    $passed Passed.
	 * @param int    $product_id Product ID.
	 * @param int    $quantity Quantity.
	 * @param string $variation_id Variation ID.
	 * @param string $variations Variations.
	 * @return string
	 */
	public function add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = '', $variations = '' ) {

		$product_min = $this->get_product_min_limit( $product_id );

		if ( ! empty( $product_min ) ) {
			// min is empty
			if ( false !== $product_min ) {
				$new_min = $product_min;
			} else {
				// neither max is set, so get out
				return $passed;
			}
		}

		return $passed;
	}

	/**
	 * Get Product Minimum Limit.
	 *
	 * @param int $product_id Product ID.
	 * @return int
	 */
	public function get_product_min_limit( $product_id ) {
		$qty = get_post_meta( $product_id, '_wc_min_qty_product', true );

		if ( empty( $qty ) ) {
			$limit = false;
		} else {
			$limit = (int) $qty;
		}

		return $limit;
	}
}
