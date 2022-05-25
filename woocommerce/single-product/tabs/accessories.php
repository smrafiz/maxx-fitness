<?php
/**
 * Accessories tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/accessories.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$accessories = get_field( 'mfit_product_accessories' );
$ids         = ! empty( $accessories ) ? implode( ', ', $accessories ) : null;
$pr_per_page = ! empty( $accessories ) ? count( $accessories ) : 3;

echo '<div class="mfit-product-tab-body tab-accessories-wrapper">';

if ( ! empty( $ids ) ) {
	echo do_shortcode( '[mfit_products limit="' . absint( $pr_per_page ) . '" ids="' . $ids . '" columns="3"]' );
} else {
	echo '<p>Nichts gefunden.</p>';
}

echo '</div>';
