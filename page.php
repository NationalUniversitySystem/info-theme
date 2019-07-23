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
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--fluid">
				<div class="container">
					<div class="row">
						<?php get_template_part( 'template-parts/hero.php' ); ?>
						<?php get_template_part( 'template-parts/form.php' ); ?>
					</div>
				</div>
			</section>

			<section class="info-section info-section--widgets">
				<div class="container">
					<div class="row">
						<?php
						get_template_part( 'template-parts/widget' );

						get_template_part( 'template-parts/widget', 'alt' );
						?>
					</div>
				</div>
			</section>

			<?php get_template_part( 'template-parts/quote' ); ?>

			<?php get_template_part( 'template-parts/accolades' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
