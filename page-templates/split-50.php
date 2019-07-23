<?php
/**
 * Template Name: Split 50-50
 * Template Post Type: page
 *
 * @package nusa
 */

get_header( 'basic' );
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="info-section info-section--split">
				<div class="row">
					<?php require locate_template( 'template-parts/form.php' ); ?>
					<div class="background-caption">
						N'dea M., Class of 2018
					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div class="modal fade" id="thanks-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="icon icon-cancel close" data-dismiss="modal"></button>
					<h3>Thank You</h3>
					<p>Your information has been submitted! <span> We'll be in touch.</span></p>
					<a href="#" class="button button--yellow">Done</a>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer( 'basic' );
