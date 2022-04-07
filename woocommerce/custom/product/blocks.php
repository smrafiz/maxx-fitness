<?php
/**
 * Product block
 *
 * Contains the markup for product block.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

if ( ! isset( $product ) ) {
	return;
}

if ( ! isset( $block_data ) ) {
	$block_data = array();
}

$defaults = array(
	'type'           => isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : 'grid',
	'layout'         => 1,
	'list_layout'    => 1,
	'thumb_size'     => 'woocommerce_thumbnail',
	'cat_display'    => false,
	'rating_display' => true,
	'wishlist'       => true,
	'compare'        => true,
	'quickview'      => false,
	'gallery'        => true,

);

$block_data = wp_parse_args( $block_data, $defaults );

if ( 'list' === $block_data['type'] ) {
	wc_get_template(
		'custom/product/list.php',
		compact( 'product', 'block_data' )
	);
} else {
	wc_get_template(
		'custom/product/grid.php',
		compact( 'product', 'block_data' )
	);
}
