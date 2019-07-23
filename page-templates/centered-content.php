<?php
/**
 * Template Name: Centered Content
 * Template Post Type: page
 *
 * @package nusa
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="info-section info-section--content">
				<div class="container">
					<div class="row">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content', 'page' );
						endwhile; // End of the loop.
						?>
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
