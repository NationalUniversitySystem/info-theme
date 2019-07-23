<?php
/**
 * Most basic form of content
 *
 * @package nusa
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--widgets">
				<div class="container">
					<div class="row">
						<?php get_template_part( 'template-parts/content/content', 'page' ); ?>
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
