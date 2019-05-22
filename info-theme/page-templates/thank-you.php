<?php
/**
 * Template Name: Thank You
 * Template Post Type: page
 *
 * @package nusa
 */

get_header();
require locate_template( 'template-parts/vars.php' );

$utm_medium   = ! empty( $_GET['utm_medium'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) ) : '';
$utm_campaign = ! empty( $_GET['utm_campaign'] ) ? substr( sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ), -3 ) : '';
$eq_form      = ! empty( $_GET['elqFormName'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['elqFormName'] ) ) ) : '';
$first_name   = ! empty( $_GET['fname'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['fname'] ) ) ) : '';
$last_name    = ! empty( $_GET['lname'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['lname'] ) ) ) : '';
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( 'cpc' === $utm_medium && in_array( $utm_campaign, array( '_ca', '_la', '_sd' ), true ) ) { ?>

				<section class="info-section info-section--content info-section--applite">
					<div class="container">
						<?php require locate_template( 'template-parts/thank-you/applite.php' ); ?>
					</div>
				</section>

			<?php } elseif ( 'reengagementsurvey' === $eq_form ) { ?>

			<section class="info-section info-section--content info-section--reengage">
				<div class="container">
					<?php require locate_template( 'template-parts/thank-you/reengage.php' ); ?>
				</div>
			</section>

			<?php } else { ?>

			<section class="info-section info-section--content">
				<div class="container">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/content', 'page' );
					endwhile; // End of the loop.
					?>
				</div>
			</section>

			<?php } ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
