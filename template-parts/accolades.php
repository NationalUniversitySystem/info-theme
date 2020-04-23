<?php
/**
 * Template for Displaying Accolades
 *
 * @package info.*.edu
 */

$awards = get_post_meta( get_the_ID(), '_awards_list', true );

if ( $awards ) {
	$awards_count = count( $awards );
	?>

	<section class="section accolades py-6 position-relative">
		<h2 class="mb-5">Accreditations</h2>

		<div class="container">
			<div class="row">
				<button type="button" role="presentation" class="d-md-none position-absolute accolades__nav accolades__nav--prev" aria-label="Previous">‹</button>
				<div class="accolades__wrap col d-md-flex justify-content-around p-0">
					<?php
					foreach ( $awards as $award ) {
						$award_alt = get_post_meta( $award, '_wp_attachment_image_alt', true );
						$award     = is_int( $award ) ? wp_get_attachment_image( $award, 'full' ) : $award;
						?>
						<article class="accolade col-md align-items-md-center justify-content-md-center p-0" aria-label="Accolade <?php echo esc_attr( $award_alt ); ?>">
							<?php echo wp_kses_post( $award ); ?>
						</article>
						<?php
					}
					?>
				</div>
				<button type="button" role="presentation" class="d-md-none position-absolute accolades__nav accolades__nav--next" aria-label="Next">›</a>
			</div>
		</div>
	</section>

	<?php
}
