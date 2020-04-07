<?php
/**
 * The template for displaying all pages
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
					<?php get_template_part( 'template-parts/form' ); ?>
				</div>
			</div>
		</section>

		<section class="section section--content">
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

		<?php get_template_part( 'template-parts/widgets' ); ?>

		<?php get_template_part( 'template-parts/quote' ); ?>

		<?php get_template_part( 'template-parts/accolades' ); ?>
	</main><!-- #main -->
<?php
get_footer();
