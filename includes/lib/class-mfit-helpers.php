<?php
/**
 * The Helpers class.
 * We're using this one to accumulates various helper methods.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Helpers class.
 *
 * @since 1.0.0
 */
class Mfit_Helpers {

	/**
	 * Query WooCommerce activation.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function has_woocommerce() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}

	/**
	 * Query Jetpack activation.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function has_jetpack() {
		return class_exists( 'Jetpack' ) ? true : false;
	}

	/**
	 * Check if we're on an Event page.
	 *
	 * @static
	 * @access public
	 * @param int|false $id The page ID.
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_tribe_event( $id = false ) {
		if ( function_exists( 'tribe_is_event' ) ) {
			if ( false === $id ) {
				return (bool) tribe_is_event();
			} else {
				return (bool) tribe_is_event( $id );
			}
		}

		return false;
	}

	/**
	 * Query if inside WooCommerce Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_woocommerce() {
		if ( function_exists( 'is_woocommerce' ) ) {
			return (bool) is_woocommerce();
		}

		return false;
	}

	/**
	 * Query if inside WooCommerce Shop Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_shop() {
		if ( function_exists( 'is_shop' ) ) {
			return (bool) is_shop();
		}

		return false;
	}

	/**
	 * Query if inside WooCommerce category Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_product_cat() {
		if ( function_exists( 'is_product_category' ) ) {
			return (bool) is_product_category();
		}

		return false;
	}

	/**
	 * Query if inside WooCommerce top category Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_top_product_cat() {
		if ( is_shop() || is_product() || is_search() || is_404() ) {
			return;
		}

		if ( function_exists( 'is_product_category' ) ) {
			$terms = get_queried_object();

			if ( 0 === $terms->parent ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Query if inside WooCommerce attribute Page.
	 *
	 * @static
	 * @access public
	 * @return bool
	 *
	 * since 1.0.0
	 */
	public static function inside_product_attribute() {
		if ( is_shop() || is_product() || is_search() ) {
			return;
		}

		if ( is_tax() && function_exists( 'taxonomy_is_product_attribute' ) ) {
			$tax_obj = get_queried_object();
			return taxonomy_is_product_attribute( $tax_obj->taxonomy );
		}

		return false;
	}

	/**
	 * Return the image markup.
	 *
	 * @since  1.0.0
	 * @access public
	 * @static
	 *
	 * @param string  $size image size.
	 * @param integer $id post id.
	 * @param string  $class image CSS class.
	 * @return mixed
	 */
	public static function render_image( $size = 'full', int $id = null, $class = '' ) {
		$alt_text = trim( wp_strip_all_tags( get_post_meta( absint( $id ), '_wp_attachment_image_alt', true ) ) );

		return wp_get_attachment_image(
			absint( $id ),
			esc_attr( $size ),
			false,
			array(
				'class' => esc_attr( $class ),
				'alt'   => esc_attr( $alt_text ),
			)
		);
	}

	/**
	 * Get custom Woocommerce templates.
	 *
	 * @param string $template Template name.
	 * @param array  $args Template args.
	 * @return void
	 */
	public static function get_custom_template_part( $template, $args = array() ) {
		$template = 'woocommerce/custom/template-parts/' . $template;
		self::get_template_part( $template, $args );
	}

	/**
	 * Get template partials.
	 *
	 * @param string $template Template name.
	 * @param array  $args Template args.
	 * @return void
	 */
	public static function get_template_part( $template, $args = array() ) {
		extract( $args );

		$template = '/' . $template . '.php';
		$file     = get_template_directory() . $template;

		require $file;
	}

	/**
	 * Get product thumbnail.
	 *
	 * @param object $product Product.
	 * @param string $thumb_size Thumbnail size.
	 * @return string
	 */
	public static function get_product_thumbnail( $product, $thumb_size = 'woocommerce_thumbnail' ) {
		$thumbnail = $product->get_image( $thumb_size, array(), false );

		if ( ! $thumbnail ) {
			$thumbnail = wc_placeholder_img( $thumb_size );
		}

		return $thumbnail;
	}

	/**
	 * Get product thumbnail link.
	 *
	 * @param object $product Product.
	 * @param string $thumb_size Thumbnail size.
	 * @return string
	 */
	public static function get_product_thumbnail_link( $product, $thumb_size = 'woocommerce_thumbnail' ) {
		return '<a href="' . esc_attr( $product->get_permalink() ) . '">' . self::get_product_thumbnail( $product, $thumb_size ) . '</a>';
	}

	/**
	 * Prints wishlist icon.
	 *
	 * @param boolean $icon Icon.
	 * @param boolean $text Text.
	 * @return void|boolean
	 */
	public static function print_wishlist_icon( $icon = true, $text = false ) {
		if ( ! defined( 'YITH_WCWL' ) ) {
			return false;
		}

		self::get_custom_template_part( 'wishlist-icon', compact( 'icon', 'text' ) );
	}

	/**
	 * Prints cart icon.
	 *
	 * @param boolean $icon Icon.
	 * @param boolean $text Text.
	 * @return void
	 */
	public static function print_cart_icon( $icon = true, $text = true ) {
		global $product;

		$qty = get_post_meta( $product->get_id(), '_wc_min_qty_product', true );

		$quantity = ! empty( $qty ) ? $qty : 1;
		$class    = implode(
			' ',
			array_filter(
				array(
					'action-cart button product_type_variable mfit_add_to_cart mfit_ajax_add_to_cart ',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				)
			)
		);

		$html       = '';
		$images_uri = get_parent_theme_file_uri( 'assets/images/' );

		if ( $icon ) {
			$html .= '<img width="30" height="30" src="' . esc_url( $images_uri . 'cart.svg' ) . '" alt="' . esc_html__( 'Cart Button', 'maxx-fitness' ) . '">';
		}

		echo sprintf(
			'<div class="action-btn" title="%1$s"><a rel="nofollow" href="%2$s" data-quantity="%3$s" data-product_id="%4$s" data-product_sku="%5$s" class="%6$s">' . $html . '</a></div>',
			esc_attr( $product->add_to_cart_text() ),
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : 'action-cart' )
		);
	}

	/**
	 * Prints link icon.
	 *
	 * @return void
	 */
	public static function print_link_icon() {
		global $product;
		$html       = '';
		$images_uri = get_parent_theme_file_uri( 'assets/images/' );

		$html .= '<img width="30" height="30" src="' . esc_url( $images_uri . 'link.svg' ) . '" alt="' . esc_html__( 'Product Link Button', 'maxx-fitness' ) . '">';

		echo sprintf(
			'<div class="action-btn" title="%1$s"><a href="%2$s" class="%3$ss">' . $html . '</a></div>',
			esc_attr( __( 'Weitere Details', 'maxx-fitness' ) ),
			esc_url( get_permalink( $product->get_id() ) ),
			esc_attr( 'mfit-product-link' )
		);
	}

	/**
	 * Get shop URL - Grid View.
	 *
	 * @return string
	 */
	public static function shop_grid_page_url() {
		global $wp;
		$current_url = add_query_arg( $wp->query_string, '&view=grid', home_url( $wp->request ) );
		return $current_url;
	}

	/**
	 * Get shop URL - List View.
	 *
	 * @return string
	 */
	public static function shop_list_page_url() {
		global $wp;
		$current_url = add_query_arg( $wp->query_string, '&view=list', home_url( $wp->request ) );
		return $current_url;
	}

	/**
	 * Get all attribute terms.
	 *
	 * @param string $pa Product attribute name.
	 * @return array
	 */
	public static function get_all_attribute_terms( $pa ) {
		$terms = get_terms( $pa );

		if ( empty( $terms ) ) {
			return array();
		}

		$term_ids = wp_list_pluck( $terms, 'term_id' );

		return $term_ids;
	}
}
