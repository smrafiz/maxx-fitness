<?php
/**
 * Template Name: MAXX - Home Page
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

get_header();
?>

<div id="content" class="content-area">
	<div id="home" class="homepage-content">
		<main id="primary" class="site-main" role="main">
			<?php
			while ( have_posts() ) {
				the_post();

				get_template_part( 'views/content/content', 'page' );
			}
			?>
		</main><!-- #primary -->
	</div><!-- #home -->
</div><!-- #content -->

<?php
get_footer();
