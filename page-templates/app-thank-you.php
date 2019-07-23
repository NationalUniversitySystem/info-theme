<?php
/**
 * Template Name: App Thank You
 * Template Post Type: page
 *
 * @package nusa
 */

$first_name = ! empty( $_GET['first_name'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['first_name'] ) ) ) : '';
$last_name  = ! empty( $_GET['last_name'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['last_name'] ) ) ) : '';

if ( empty( $first_name ) || empty( $last_name ) ) {
	$site_url = site_url();
	wp_safe_redirect( $site_url );
	exit;
}

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--content info-section--applite">
				<div class="container">
					<?php require locate_template( 'template-parts/thank-you/app.php' ); ?>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
