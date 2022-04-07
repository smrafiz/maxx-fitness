<?php
/**
 * Wishlist Icon.
 *
 * Contains the markup for wishlist icon.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

if ( ! function_exists( 'YITH_WCWL' ) ) {
	return;
}

global $product;
$product_id     = $product->get_id();
$is_in_wishlist = YITH_WCWL()->is_product_in_wishlist( $product_id, false );
$wishlist_url   = YITH_WCWL()->get_wishlist_url();

$title_before = esc_html__( 'Zur Wunschliste hinzufügen', 'maxx-fitness' );
$title_after  = esc_html__( 'Bereits in Wunschliste vorhanden!', 'maxx-fitness' );

if ( $is_in_wishlist ) {
	$class     = 'mfit-remove-from-wishlist';
	$icon_font = 'fa fa-heart';
	$title     = $title_after;
} else {
	$class     = 'mfit-add-to-wishlist';
	$icon_font = 'fa fa-heart-o';
	$title     = $title_before;
}

$html = '';

if ( $icon ) {
	$images_uri = get_parent_theme_file_uri( 'assets/images/' );
	$html .= '<img width="30" height="30" src="' . esc_url( $images_uri . 'wishlist.svg' ) . '" alt="' . esc_html__( 'Wishlist Button', 'maxx-fitness' ) . '">';
}

$html .= '<i class="ajax-loading fa fa-spinner fa-spin"></i>';

if ( $text ) {
	$html .= '<span>' . esc_html__( 'WishList', 'maxx-fitness' ) . '</span>';
}

$nonce = wp_create_nonce( 'add_to_wishlist' );

?>
<div class="action-btn" title="<?php echo esc_attr( $title ); ?>">
	<a href="<?php echo esc_url( $wishlist_url ); ?>" rel="nofollow" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-title-after="<?php echo esc_attr( $title_after ); ?>" class="mfit-wishlist-icon <?php echo esc_attr( $class ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" target="_blank">
		<?php echo wp_kses_post( $html ); ?>
	</a>
</div>
