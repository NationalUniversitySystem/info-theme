<?php
/**
 * Most basic form of content
 *
 * @package nusa
 */

get_header();
?>
	<main id="main" class="site-main">

		<section class="section section--widgets">
			<div class="container">
				<div class="row">
					<?php get_template_part( 'template-parts/content/content', 'page' ); ?>
				</div>
			</div>
		</section>

	</main><!-- #main -->
<?php
get_footer();
