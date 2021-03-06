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

					<?php if ( ! empty( get_the_content( null, false, get_the_ID() ) ) ) { ?>
						<section class="section section--content px-xl-5 px-8">
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
					<?php } ?>

					<?php get_template_part( 'template-parts/widgets' ); ?>

					<?php get_template_part( 'template-parts/quote' ); ?>

					<?php get_template_part( 'template-parts/accolades' ); ?>
				</div>
			</div>
		</section>
	</main><!-- #main -->
<?php
get_footer();
