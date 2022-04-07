<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

// echo wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped.

$rating = $product->get_average_rating();
$count  = $product->review_count ? $product->review_count : 0;

$rating_html = '<div class="star-rating-wrapper"><div class="star-rating"><span style="width:' . esc_attr( ( $rating / 5 ) * 100 ) . '%"></span></div><div class="review-count">(' . $count . ')</div></div>';

echo $rating_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

// Now we display the product short description. This is optional.
wc_get_template( 'single-product/short-description.php' );
