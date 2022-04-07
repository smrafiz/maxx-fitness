<?php
/**
 * Product block
 *
 * Contains the markup for product list view.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

$p_id = $product->get_id();
?>
<div class="mfit-product-block mfit-list-view">
	<div class="mfit-thumb-wrapper">
		<div class="mfit-thumb">
			<?php
			echo Mfit_helpers::get_product_thumbnail_link( $product, $block_data['thumb_size'] )
			?>
		</div>
		<?php woocommerce_show_product_loop_sale_flash(); ?>
	</div>

	<div class="mfit-content">
		<div class="mfit-title-area">
			<?php
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
			<h3 class="mfit-title"><a class="mfit-text primary" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
		</div>

		<?php
		if ( $block_data['rating_display'] ) {
			wc_get_template( 'loop/rating.php' );
		}
		?>

		<div class="mfit-price-area">
			<?php
			if ( $price_html = $product->get_price_html() ) {
				?>
				<div class="mfit-price price"><?php echo wp_kses_post( $price_html ); ?></div>
				<?php
			}
			?>
		</div>
		<div class="mfit-buttons-area">
			<div class="mfit-buttons">
				<?php
				Mfit_helpers::print_link_icon();

				if ( $block_data['wishlist'] ) {
					Mfit_helpers::print_wishlist_icon();
				}

				Mfit_helpers::print_cart_icon( true );
				?>
			</div>
		</div>
	</div>

</div>
