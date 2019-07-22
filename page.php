<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package nusa
 */

get_header();
require locate_template( 'template-parts/vars.php' );
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

			<section class="info-section info-section--widgets">
				<div class="container">
					<div class="row">
						<?php
						if ( $columns ) {
							require locate_template( 'template-parts/widget.php' );
						}
						?>
						<?php
						if ( $custom_callout || $global_callout ) {
							require locate_template( 'template-parts/widget-alt.php' );
						}
						?>
					</div>
				</div>
			</section>

			<?php if ( $quote_text ) { ?>
				<section class="info-section info-section--quote">
					<div class="container">
						<div class="row">
							<?php require locate_template( 'template-parts/quote.php' ); ?>
						</div>
					</div>
				</section>
			<?php } ?>

			<?php get_template_part( 'template-parts/accolades' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
