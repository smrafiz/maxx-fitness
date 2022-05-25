<?php
/**
 * Template Functions.
 * List of all template functions which enhance the theme by
 * hooking into WordPress.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Removing category title prefix.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

add_filter( 'body_class', 'mfit_body_classes' );
if ( ! function_exists( 'mfit_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function mfit_body_classes( $classes ) {

		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		// Adds a class to blogs with more than 1 published author.
		$classes[] = is_multi_author() ? 'group-blog' : '';

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'mfit-sidebar-general' ) || ! is_active_sidebar( 'mfit-sidebar-blog' ) ) {
			$classes[] = 'no-general-sidebar';
		}

		// Adds a class when Woocommerce is detected.
		$classes[] = class_exists( 'Woocommerce' ) ? 'woocommerce-active' : '';

		if ( isset( $_GET['view'] ) && 'list' === $_GET['view'] ) {
			$classes[] = 'product-list-view';
		} else {
			$classes[] = 'product-grid-view';
		}

		// the list of WordPress global browser checks.
		// https://codex.wordpress.org/Global_Variables#Browser_Detection_Booleans.
		$browsers = array( 'iphone', 'chrome', 'safari', 'NS4', 'opera', 'macIE', 'winIE', 'gecko', 'lynx', 'IE', 'edge' );

		// check the globals to see if the browser is in there and return a string with the match.
		$classes[] = join(
			' ',
			array_filter(
				$browsers,
				function ( $browser ) {
					return '' . $GLOBALS[ 'is_' . $browser ];
				}
			)
		);

		return $classes;
	}
}

add_action( 'wp_head', 'mfit_pingback_header' );
if ( ! function_exists( 'mfit_pingback_header' ) ) {
	/**
	 * Adds a ping-back url auto-discovery header for
	 * single posts, pages, or attachments.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
}

add_action( 'wp_footer', 'mfit_handheld_menu_mask' );
if ( ! function_exists( 'mfit_handheld_menu_mask' ) ) {
	/**
	 * Adds an empty placeholder div for handheld menu masking.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_handheld_menu_mask() {
		?>
		<div id="mfit-menu-mask" class="mfit-menu-mask"></div>
		<!-- <?php echo esc_attr__( 'Empty placeholder for handheld Menu masking.', 'maxx-fitness' ); ?> -->
		<?php
	}
}

add_action( 'wp_footer', 'mfit_scroll_to_top' );
if ( ! function_exists( 'mfit_scroll_to_top' ) ) {
	/**
	 * Adds a scroll to top button.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_scroll_to_top() {
		if ( false === get_theme_mod( 'mfit_enable_totop', true ) ) {
			return;
		}

		echo '<div class="mfit-scroll-to-top"><i class="fa fa-angle-up"></i><i class="fa fa-angle-double-up"></i></div>';
	}
}

add_filter( 'the_title', 'mfit_empty_post_title' );
if ( ! function_exists( 'mfit_empty_post_title' ) ) {
	/**
	 * Adds a title to posts and pages that are missing titles.
	 *
	 * @param string $title The title.
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function mfit_empty_post_title( $title ) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'maxx-fitness' ) : $title;
	}
}

add_action( 'wp_head', 'mfit_header_code' );
if ( ! function_exists( 'mfit_header_code' ) ) {
	/**
	 * Adds header code.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_header_code() {
		$header_code = get_theme_mod( 'mfit_header_code', '' );

		if ( $header_code ) {
			echo $header_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

add_action( 'wp_footer', 'mfit_footer_code' );
if ( ! function_exists( 'mfit_footer_code' ) ) {
	/**
	 * Adds footer code.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_footer_code() {
		$footer_code = get_theme_mod( 'mfit_footer_code', '' );

		if ( $footer_code ) {
			echo $footer_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

add_action( 'wp_body_open', 'mfit_pageloader' );
if ( ! function_exists( 'mfit_pageloader' ) ) {
	/**
	 * Adds a page loading animation.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_pageloader() {
		if ( false === get_theme_mod( 'mfit_enable_pageloader', true ) ) {
			return;
		}
		?>
		<div class="mfit-pageloader">
			<div class="pageloader-inner">
				<div class="loader-circle">
					<div></div>
				</div>
			</div>
		</div>
		<?php
	}
}

add_action( 'init', 'mfit_rename_post_object' );
if ( ! function_exists( 'mfit_rename_post_object' ) ) {
	/**
	 * Renaming post object.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	function mfit_rename_post_object() {
		global $wp_post_types;

		$labels                     = $wp_post_types['post']->labels;
		$labels->name               = __( 'Magazines', 'maxx-fitness' );
		$labels->singular_name      = __( 'Magazine', 'maxx-fitness' );
		$labels->add_new            = __( 'Add New', 'maxx-fitness' );
		$labels->add_new_item       = __( 'Add New', 'maxx-fitness' );
		$labels->edit_item          = __( 'Edit Magazine', 'maxx-fitness' );
		$labels->new_item           = __( 'Magazine', 'maxx-fitness' );
		$labels->view_item          = __( 'View Magazine', 'maxx-fitness' );
		$labels->search_items       = __( 'Search Magazines', 'maxx-fitness' );
		$labels->not_found          = __( 'No Magazines found', 'maxx-fitness' );
		$labels->not_found_in_trash = __( 'No Magazines found in Trash', 'maxx-fitness' );
		$labels->all_items          = __( 'All Magazines', 'maxx-fitness' );
		$labels->menu_name          = __( 'Magazines', 'maxx-fitness' );
		$labels->name_admin_bar     = __( 'Magazines', 'maxx-fitness' );
	}
}

add_filter( 'admin_post_thumbnail_html', 'mfit_featured_image_html' );
if ( ! function_exists( 'mfit_featured_image_html' ) ) {
	/**
	 * Custom notice for featured image.
	 *
	 * @param string $html Featured image HTML.
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function mfit_featured_image_html( $html ) {
		if ( 'post' === get_post_type() ) {
			$html .= '<p><b><u>Note:</u></b> Upload Fitness Magazine Image as Featured Image here. Recommended image size is <b>800x533</b> px or greater (maintaining same aspect ratio).</p>';
		}

		if ( 'product' === get_post_type() ) {
			$html .= '<p><b><u>Note:</u></b> Recommended image size for product is <b>1000x1000</b> px or greater (maintaining same aspect ratio).</p>';
		}

		return $html;
	}
}
