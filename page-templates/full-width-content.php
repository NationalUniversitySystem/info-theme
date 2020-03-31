<?php
/**
 * Template Name: Full Width Content
 * Template Post Type: page
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

		<section class="section section--content py-8">
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


		<div class="split-wrap d-flex flex-wrap">
			<?php
			// Widget with border.
			$custom_callout = get_post_meta( get_the_ID(), '_callout', true );
			$callout_text   = ! empty( $custom_callout ) ? $custom_callout : get_theme_mod( 'callout' );
			if ( ! empty( $callout_text ) ) {
				?>

				<section class="section section--widgets p-0 col-12 col-md-6">
					<div class="container">
						<div class="row">
							<div class="widget widget--alt col-12 col-lg-4 p-5 d-md-flex flex-lg-wrap align-content-lg-center">
								<?php echo wp_kses_post( $callout_text ); ?>
							</div>
						</div>
					</div>
				</section>

				<?php
			}
			?>

			<?php get_template_part( 'template-parts/quote' ); ?>
		</div>

		<?php get_template_part( 'template-parts/accolades' ); ?>
	</main><!-- #main -->
<?php
get_footer();
