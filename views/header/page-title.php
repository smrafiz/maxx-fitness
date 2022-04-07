<?php
/**
 * Displays the page title.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

$breadcrumbs         = Mfit_Breadcrumbs::get_instance();
$disable_breadcrumbs = get_field( 'mfit_meta_disable_breadcrumbs' );

if ( ! $disable_breadcrumbs ) {
	?>
	<div id="page-title" class="page-title image-in-bg size-cover">
		<div class="breadcrumbs-section">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12">
						<?php
						if ( get_theme_mod( 'mfit_enable_breadcrumbs', false ) ) {
							// Breadcrumbs.
							$breadcrumbs->get_breadcrumbs(
								array(
									'delimiter'          => '/',
									'display_terms'      => true,
									'cat_archive_prefix' => false,
									'tag_archive_prefix' => false,
									'display_post_type_archive' => false,
								)
							);
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>

<div class="pagetitle-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
				<h1 class="mb-0"><?php mfit_the_page_title(); ?></h1>
			</div>
		</div>
	</div>
</div>
