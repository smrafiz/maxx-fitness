<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( is_single() && is_active_sidebar( 'mfit-sidebar-blog' ) ) {
	dynamic_sidebar( 'mfit-sidebar-blog' );
} elseif ( Mfit_Helpers::has_woocommerce() && is_active_sidebar( 'mfit-sidebar-caregory' ) && Mfit_Helpers::inside_top_product_cat() ) {
	dynamic_sidebar( 'mfit-sidebar-caregory' );
} elseif ( Mfit_Helpers::has_woocommerce() && is_active_sidebar( 'mfit-sidebar-products' ) && Mfit_Helpers::inside_product_cat() ) {
	dynamic_sidebar( 'mfit-sidebar-products' );
} elseif ( Mfit_Helpers::has_woocommerce() && is_active_sidebar( 'mfit-sidebar-products' ) && Mfit_Helpers::inside_product_attribute() ) {
	dynamic_sidebar( 'mfit-sidebar-products' );
} elseif ( Mfit_Helpers::has_woocommerce() && is_active_sidebar( 'mfit-sidebar-products' ) && Mfit_Helpers::inside_woocommerce() ) {
	dynamic_sidebar( 'mfit-sidebar-products' );
} elseif ( is_home() && is_active_sidebar( 'mfit-sidebar-blog' ) ) {
	dynamic_sidebar( 'mfit-sidebar-blog' );
} elseif ( is_archive() && is_active_sidebar( 'mfit-sidebar-blog' ) ) {
	dynamic_sidebar( 'mfit-sidebar-blog' );
} else {
	dynamic_sidebar( 'mfit-sidebar-general' );
}
