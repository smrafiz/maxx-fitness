<?php
/**
 * Technical Data tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/technical-data.php.
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

echo '<div class="mfit-product-tab-body tab-techdata-wrapper">';
echo '<ul class="product-data">';

for ( $i = 1; $i < 51; $i++ ) {
	if ( ! empty( get_field( "mfit_product_data_$i" ) ) ) {
		if ( ! empty( get_field( "mfit_product_data_$i" )['title'] ) && ! empty( get_field( "mfit_product_data_$i" )['value'] ) ) {
			echo '<li>';
			echo '<span class="data-title">' . get_field( "mfit_product_data_$i" )['title'] . '</span>';
			echo '<span class="data-value">' . get_field( "mfit_product_data_$i" )['value'] . '</span>';
			echo '</li>';
		}
	}
}

echo '</ul>';
echo '</div>';
