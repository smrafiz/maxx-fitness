<?php
/**
 * Videos tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/videos.php.
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

$video_01      = get_field( 'mfit_video_1' );
$video_02      = get_field( 'mfit_video_2' );
$video_01_id   = null;
$video_02_id   = null;
$iframe_01_src = null;
$iframe_02_src = null;

if ( ! empty( $video_01 ) ) {
	$video_01_id = get_field( 'mfit_video_1' )['video_id'];
}

if ( ! empty( $video_02 ) ) {
	$video_02_id = get_field( 'mfit_video_2' )['video_id'];
}

if ( ! empty( $video_01_id ) ) {
	$iframe_01_src = 'https://www.youtube.com/embed/' . $video_01_id . '?rel=0';
}

if ( ! empty( $video_02_id ) ) {
	$iframe_02_src = 'https://www.youtube.com/embed/' . $video_02_id . '?rel=0';
}

echo '<div class="mfit-product-tab-body tab-videos-wrapper row">';

if ( ! empty( $video_01_id ) ) {
	echo '<div class="col-12 col-sm-12 col-md-6 video-modal swiper-slide">';
	echo '<div class="embed-responsive embed-responsive-16by9">';
	echo '<iframe class="embed-responsive-item" src="' . esc_url( $iframe_01_src ) . '" allowfullscreen></iframe>';
	echo '</div>';
	echo '</div>';
}

if ( ! empty( $video_02_id ) ) {
	echo '<div class="col-12 col-sm-12 col-md-6 video-modal swiper-slide">';
	echo '<div class="embed-responsive embed-responsive-16by9">';
	echo '<iframe class="embed-responsive-item" src="' . esc_url( $iframe_02_src ) . '" allowfullscreen></iframe>';
	echo '</div>';
	echo '</div>';
}

echo '</div>';
