<?php
/**
 * Template Name: Full Width Hero
 *
 * @package nusa
 */

get_header();
?>
	<main id="main" class="site-main">
		<section class="section section--fluid">
			<div class="container">
				<div class="row">
					<?php get_template_part( 'template-parts/hero' ); ?>
				</div>
			</div>
		</section>

		<section class="section section--content pt-5">
			<div class="container">
				<div class="row">
					<div class="dynamic-content col-12 col-lg-8">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content/content', 'page' );
						endwhile; // End of the loop.
						?>
						<span id="form"></span>
						<?php get_template_part( 'template-parts/form' ); ?>
					</div>

					<?php get_template_part( 'template-parts/widgets' ); ?>
				</div>
			</div>
		</section>
	</main><!-- #main -->
<?php
get_footer();
