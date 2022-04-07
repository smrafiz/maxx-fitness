<?php
/**
 * Shop product top bar
 *
 * Contains the markup for shop product top bar.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

if ( ! woocommerce_products_will_display() ) {
	return;
}
?>
<div class="mfit-shop-top">
	<div class="mfit-left">
		<div class="limit-show"><?php woocommerce_result_count(); ?></div>
	</div>
	<div class="mfit-right">
		<div class="sort-list"><?php woocommerce_catalog_ordering(); ?></div>
		<div class="view-mode mfit-buttons" id="shop-view-mode">
			<ul>
				<li class="grid-view-nav action-btn" title="Gallery"><a href="<?php echo esc_url( Mfit_Helpers::shop_grid_page_url() ); ?>" ><i class="fa fa-th"></i></a></li>
				<li class="list-view-nav action-btn" title="List"><a href="<?php echo esc_url( Mfit_Helpers::shop_list_page_url() ); ?>"><i class="fa fa-th-list"></i></a></li>
			</ul>
		</div>
	</div>
</div>
