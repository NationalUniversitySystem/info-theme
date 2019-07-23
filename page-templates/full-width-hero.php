<?php
/**
 * Template Name: Full Width Hero
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
					</div>
				</div>
			</section>

			<section class="info-section info-section--content">
				<div class="container">
					<div class="row">
						<div class="dynamic-content">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content/content', 'page' );
							endwhile; // End of the loop.
							?>
							<span id="form"></span>
							<?php require locate_template( 'template-parts/form.php' ); ?>
						</div>

						<aside class="info-section info-section--widgets">
							<div class="row">
								<?php
								get_template_part( 'template-parts/widget' );

								get_template_part( 'template-parts/widget', 'alt' );
								?>
							</div>
						</aside>
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
