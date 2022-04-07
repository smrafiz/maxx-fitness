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

		// Product thumb & title
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

		// Custom on-sale.
		add_filter( 'woocommerce_sale_flash', array( $this, 'sale_flash' ), 10, 3 );

		// Custom price text.
		add_filter( 'woocommerce_get_price_html', array( $this, 'product_price_display' ) );

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

		$small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
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
				$parent         = get_term_by( 'id', $category->parent, 'product_cat' );
				$category->name = esc_html( $parent->name ) . ' für <br>' . esc_html( $category->name );
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
		\YITH_WCWL_Ajax_Handler::add_to_wishlist();
		wp_die();
	}

	/**
	 * Remove from wishlist.
	 *
	 * @return void
	 */
	public function remove_from_wishlist() {
		check_ajax_referer( 'add_to_wishlist', 'nonce' );
		\YITH_WCWL_Ajax_Handler::remove_from_wishlist();
		wp_die();
	}
}
