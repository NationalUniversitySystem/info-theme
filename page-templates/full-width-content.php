<?php
/**
 * Template Name: Full Width Content
 * Template Post Type: page
 *
 * @package nusa
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--fluid">
				<div class="container">
					<div class="row">
						<?php require locate_template( 'template-parts/hero.php' ); ?>
						<?php require locate_template( 'template-parts/form.php' ); ?>
					</div>
				</div>
			</section>

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

			<div class="split-wrap">
				<section class="info-section info-section--widgets">
					<div class="container">
						<div class="row">
							<?php get_template_part( 'template-parts/widget', 'alt' ); ?>
						</div>
					</div>
				</section>

				<?php get_template_part( 'template-parts/quote' ); ?>
			</div>

			<?php get_template_part( 'template-parts/accolades' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
