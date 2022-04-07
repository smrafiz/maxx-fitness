<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mfit_class = ' mfit-products-wrapper';

if ( Mfit_Helpers::inside_product_attribute() ) {
	$mfit_class .= ' mfit-products mfit-product-attribute';
} else if ( Mfit_Helpers::inside_top_product_cat() ) {
	$mfit_class .= ' product-top-level-category';
} else {
	$mfit_class .= ' mfit-products';
}

?>
<div class="products row<?php echo esc_attr( $mfit_class ); ?>">
