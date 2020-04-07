<?php
/**
 * Template Name: Thank You
 * Template Post Type: page
 *
 * @package nusa
 */

get_header();
?>
	<main id="main" class="site-main">
		<section class="section section--content">
			<div class="container">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/content', 'page' );
				endwhile; // End of the loop.
				?>
			</div>
		</section>
	</main><!-- #main -->
<?php
get_footer();
