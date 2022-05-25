<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div class="product-price-wrapper d-flex align-items-center">
	<?php
	if ( $product->is_on_sale() ) {
		?>
		<div class="price-inner">
			<div class="price-title sale-price color-primary">Aktionspreis</div>
			<div class="price-value sale-price color-primary">
				<?php echo wc_price( $product->get_sale_price() ); ?>
			</div>
		</div>
		<div class="price-inner">
			<div class="price-title regular-price">Preis</div>
			<div class="price-value regular-price">
				<del><?php echo wc_price( $product->get_regular_price() ); ?></del>
			</div>
		</div>
		<?php
	} else {
		?>
		<div class="price-inner">
			<div class="price-title regular-price">Preis</div>
			<div class="price-value regular-price">
				<?php echo wc_price( $product->get_regular_price() ); ?>
			</div>
		</div>
		<?php
	}
	?>
</div>
