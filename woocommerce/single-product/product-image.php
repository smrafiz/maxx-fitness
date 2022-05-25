<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns               = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id     = (int) $product->get_image_id();
$gallery_thumbnail_ids = $product->get_gallery_image_ids();
$gallery_class         = ! empty( $gallery_thumbnail_ids ) ? 'gallery-with-thumbs' : 'no-gallery';

// $image_attributes = wp_get_attachment_image_src( $post_thumbnail_id );
$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'images',
	)
);

$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
$thumbnail_size    = array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] );
$image_size        = 'woocommerce_single';
$full_size         = 'full';

$total_images_id = array();
$image_tag       = array();
$total_images_id = array_unique( array_merge( explode( ' ', $post_thumbnail_id ), $gallery_thumbnail_ids ) );

$image_count     = count( $total_images_id );
$slides_per_view = '';
$thumb_class     = '';
$video_01        = get_field( 'mfit_video_1' );
$video_02        = get_field( 'mfit_video_2' );
$video_01_poster = null;
$video_02_poster = null;
$video_01_id     = null;
$video_02_id     = null;
$poster_01_alt   = '';
$poster_02_alt   = '';
$modal_01_src    = null;
$modal_02_src    = null;

if ( ! empty( $video_01 ) ) {
	$video_01_poster = get_field( 'mfit_video_1' )['poster_image'];
	$video_01_id     = get_field( 'mfit_video_1' )['video_id'];
}

if ( ! empty( $video_02 ) ) {
	$video_02_poster = get_field( 'mfit_video_2' )['poster_image'];
	$video_02_id     = get_field( 'mfit_video_2' )['video_id'];
}

if ( ! empty( $video_01_poster ) ) {
	$poster_01_alt = trim( wp_strip_all_tags( get_post_meta( $video_01_poster, '_wp_attachment_image_alt', true ) ) );
}

if ( ! empty( $video_02_poster ) ) {
	$poster_02_alt = trim( wp_strip_all_tags( get_post_meta( $video_02_poster, '_wp_attachment_image_alt', true ) ) );
}

if ( ! empty( $video_01_id ) ) {
	$modal_01_src = 'https://www.youtube.com/embed/' . $video_01_id . '?&autoplay=1';
}

if ( ! empty( $video_02_id ) ) {
	$modal_02_src = 'https://www.youtube.com/embed/' . $video_02_id . '?&autoplay=1';
}

if ( $image_count > 6 ) {
	$slides_per_view = 6;
} elseif ( $image_count > 5 ) {
	$slides_per_view = 5;
} elseif ( $image_count > 4 ) {
	$slides_per_view = 4;
	$thumb_class     = ' four-img';

	if ( ! empty( $video_01_id ) || ! empty( $video_02_id ) ) {
		$slides_per_view = 5;
		$thumb_class     = '';
	}
} elseif ( $image_count == 3 ) {
	$slides_per_view = 3;
	$thumb_class     = ' three-img';

	if ( ! empty( $video_01_id ) || ! empty( $video_02_id ) ) {
		$slides_per_view = 4;
		$thumb_class     = ' four-img';
	}
} elseif ( $image_count == 2 ) {
	$slides_per_view = 2;
	$thumb_class     = ' two-img';

	if ( ! empty( $video_01_id ) || ! empty( $video_02_id ) ) {
		$slides_per_view = 3;
		$thumb_class     = ' three-img';
	}
} elseif ( $image_count == 1 ) {
	$slides_per_view = 1;
	$thumb_class     = ' one-img';

	if ( ! empty( $video_01_id ) || ! empty( $video_02_id ) ) {
		$slides_per_view = 2;
		$thumb_class     = ' two-img';
	}
} else {
	$slides_per_view = 4;
}

?>
<div class="<?php echo $gallery_class . ' '; ?><?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

<?php
if ( empty( $gallery_thumbnail_ids ) ) {
	if ( $product->get_image_id() ) {
		foreach ( $total_images_id as $img_id1 ) {
			$thumbnail_src1 = wp_get_attachment_image_src( $img_id1, $thumbnail_size );
			$full_src1      = wp_get_attachment_image_src( $img_id1, $full_size );
			$alt_text1      = trim( wp_strip_all_tags( get_post_meta( $img_id1, '_wp_attachment_image_alt', true ) ) );
			echo '<div class="image-modal swiper-slide">';
			echo '<figure class="image-popup">';
				echo '<a href="' . $full_src1[0] . '" data-size="' . esc_attr( $full_src1[1] ) . 'x' . esc_attr( $full_src1[2] ) . '">';
					echo wp_get_attachment_image(
						$img_id1,
						$image_size,
						false,
						array(
							'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $img_id1 ), ENT_QUOTES, 'UTF-8', true ),
							'data-src'                => esc_url( $full_src1[0] ),
							'data-large_image'        => esc_url( $full_src1[0] ),
							'data-large_image_width'  => esc_attr( $full_src1[1] ),
							'data-large_image_height' => esc_attr( $full_src1[2] ),
							'class'                   => 'wp-post-image',
							'alt'                     => esc_attr( $alt_text1 ),
						)
					);
				echo '</a>';
			echo '</figure>';
			echo '</div>';
		}
	}

	if ( ! empty( $video_01_poster ) && ! empty( $video_01_id ) ) {
		echo '<div class="video-modal swiper-slide">';
		echo '<div class="modal-inner pos-r">';
		echo wp_get_attachment_image(
			$video_01_poster,
			'thumbnail',
			false,
			array(
				'class' => 'wp-post-image',
				'alt'   => esc_attr( $poster_01_alt ),
			)
		);
		echo '</div>';
		echo '</div>';
	}

	if ( ! empty( $video_02_poster ) && ! empty( $video_02_id ) ) {
		echo '<div class="video-modal swiper-slide">';
		echo '<div class="modal-inner pos-r">';
		echo wp_get_attachment_image(
			$video_02_poster,
			'thumbnail',
			false,
			array(
				'class' => 'wp-post-image',
				'alt'   => esc_attr( $poster_02_alt ),
			)
		);
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
} else {
	?>

	<div class="product-image-container">
		<div class="product-full-image main-slider">
			<div class="swiper-wrapper">
				<?php
				if ( $gallery_thumbnail_ids && $product->get_image_id() ) {
					foreach ( $total_images_id as $img_id ) {
						$thumbnail_src = wp_get_attachment_image_src( $img_id, $thumbnail_size );
						$full_src      = wp_get_attachment_image_src( $img_id, $full_size );
						$alt_text      = trim( wp_strip_all_tags( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) );
						echo '<div class="image-modal swiper-slide image-popup">';
						echo '<figure>';
							echo '<a href="' . $full_src[0] . '" data-size="' . esc_attr( $full_src[1] ) . 'x' . esc_attr( $full_src[2] ) . '">';
								echo wp_get_attachment_image(
									$img_id,
									$image_size,
									false,
									array(
										'data-caption'     => _wp_specialchars( get_post_field( 'post_excerpt', $img_id ), ENT_QUOTES, 'UTF-8', true ),
										'data-src'         => esc_url( $full_src[0] ),
										'data-large_image' => esc_url( $full_src[0] ),
										'data-large_image_width' => esc_attr( $full_src[1] ),
										'data-large_image_height' => esc_attr( $full_src[2] ),
										'class'            => 'wp-post-image',
										'alt'              => esc_attr( $alt_text ),
									)
								);
							echo '</a>';
						echo '</figure>';
						echo '</div>';
					}
				}

				if ( ! empty( $video_01_poster ) && ! empty( $video_01_id ) ) {
					echo '<div class="video-modal swiper-slide">';
					echo '<figure>';
					echo '<a href="' . esc_url( $modal_01_src ) . '" class="mfit-modal-trigger" data-modal-src="' . esc_url( $modal_01_src ) . '" data-modal-type="embed">';
					echo wp_get_attachment_image(
						$video_01_poster,
						$image_size,
						false,
						array(
							'class' => 'wp-post-image',
							'alt'   => esc_attr( $poster_01_alt ),
						)
					);
					echo '</a>';
					echo '</figure>';
					echo '</div>';
				}

				if ( ! empty( $video_02_poster ) && ! empty( $video_02_id ) ) {
					echo '<div class="video-modal swiper-slide">';
					echo '<figure>';
					echo '<a href="' . esc_url( $modal_02_src ) . '" class="mfit-modal-trigger" data-modal-src="' . esc_url( $modal_02_src ) . '" data-modal-type="embed">';
					echo wp_get_attachment_image(
						$video_02_poster,
						$image_size,
						false,
						array(
							'class' => 'wp-post-image',
							'alt'   => esc_attr( $poster_02_alt ),
						)
					);
					echo '</a>';
					echo '</figure>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>

	<?php
	echo '<div class="product-thumb-container">';
	echo '<div class="product-thumb-image pos-r">';
	echo '<div class="nav-slider' . $thumb_class . '">';
	echo '<div class="swiper-wrapper">';
	if ( $gallery_thumbnail_ids && $product->get_image_id() ) {
		foreach ( $total_images_id as $img_id ) {
			$thumbnail_src = wp_get_attachment_image_src( $img_id, $thumbnail_size );
			$alt_text      = trim( wp_strip_all_tags( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ) );
			echo '<div class="swiper-slide">';
				echo wp_get_attachment_image(
					$img_id,
					'thumbnail',
					false,
					array(
						'class' => 'wp-post-image',
						'alt'   => esc_attr( $alt_text ),
					)
				);
			echo '</div>';
		}
	}

	if ( ! empty( $video_01_poster ) && ! empty( $video_01_id ) ) {
		echo '<div class="video-modal swiper-slide">';
		echo '<div class="modal-inner pos-r">';
		echo wp_get_attachment_image(
			$video_01_poster,
			'thumbnail',
			false,
			array(
				'class' => 'wp-post-image',
				'alt'   => esc_attr( $poster_01_alt ),
			)
		);
		echo '</div>';
		echo '</div>';
	}

	if ( ! empty( $video_02_poster ) && ! empty( $video_02_id ) ) {
		echo '<div class="video-modal swiper-slide">';
		echo '<div class="modal-inner pos-r">';
		echo wp_get_attachment_image(
			$video_02_poster,
			'thumbnail',
			false,
			array(
				'class' => 'wp-post-image',
				'alt'   => esc_attr( $poster_02_alt ),
			)
		);
		echo '</div>';
		echo '</div>';
	}

	echo '</div>';
	echo '<div class="swiper-arrow next"><i class="fa fa-angle-down"></i></div>';
	echo '<div class="swiper-arrow prev"><i class="fa fa-angle-up"></i></div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	?>
</div>
	<?php
}
wp_enqueue_script( 'mfit-single-product', get_template_directory_uri() . '/assets/js/single-product.js', array( 'jquery', 'mfit-frontend-script' ), 1.0, true );
?>
<script>
	jQuery(document).ready(function($){
		var $galleryThumbs = $(".woocommerce-product-gallery.gallery-with-thumbs");
		// Params
		if($galleryThumbs.length > 0) {
			var mainSliderSelector = '.woocommerce-product-gallery .main-slider',
				navSliderSelector = '.woocommerce-product-gallery .nav-slider';

			// Main Slider
			var mainSliderOptions = {
				effect: 'fade',
				loop: true,
				speed:1000,
				spaceBetween: 0,
				loopAdditionalSlides: 10,
				watchSlidesProgress: true,
				allowTouchMove: false,
				observer: true,
				observeParents: true
			};
			var mainSlider = new Swiper(mainSliderSelector, mainSliderOptions);

			// Navigation Slider
			var navSliderOptions = {
				loop: true,
				speed:1000,
				slidesPerView: <?php echo ! empty( $slides_per_view ) ? absint( $slides_per_view ) : 6; ?>,
				loopAdditionalSlides: 10,
				direction: 'vertical',
				spaceBetween: 10,
				slideToClickedSlide: true,
				observer: true,
				observeParents: true,

				navigation: {
					nextEl: '.swiper-arrow.next',
					prevEl: '.swiper-arrow.prev'
				},

				// Responsive breakpoints
				breakpoints: {
					0: {
						slidesPerView: 3,
					},
					767: {
						slidesPerView: <?php echo ! empty( $slides_per_view ) ? absint( $slides_per_view ) : 6; ?>,
					},
				}
			};
			var navSlider = new Swiper(navSliderSelector, navSliderOptions);

			// Connecting the sliders
			mainSlider.controller.control = navSlider;
			navSlider.controller.control = mainSlider;
		}

		if ($(window).width() > 1025) {
			$('.woocommerce-product-gallery .image-modal.swiper-slide a').zoom({
				duration: 300
			});
		}

		// Modal initialization.
		jQuery('#mfit-modal').iziModal({
			width: 800,
			overlayColor: 'rgba(0, 0, 0, 0.9)',
			fullscreen: true,
			iframe : true,
			zindex: 9999,
			transitionIn: 'fadeIn',
			transitionOut: 'fadeOut',
			onOpening: function(modal) {
				modal.startLoading();
			},
			onOpened: function(modal) {
				modal.stopLoading();
			}
		});

		jQuery(document).on('click', '.mfit-modal-trigger', function (event) {
			event.preventDefault();
			jQuery('#mfit-modal').iziModal('open', event);
		});
	});
</script>
