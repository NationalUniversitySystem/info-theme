<?php
/**
 * Template for Displaying Accolades
 *
 * @package info.*.edu
 */

$awards = get_post_meta( get_the_ID(), '_nus_template_awards_list', true );
$awards = ! empty( $awards ) ? $awards : get_post_meta( get_the_ID(), '_nus_template_awards', true );

if ( $awards ) {
	$awards_count = count( $awards );
	?>

	<section class="info-section info-section--accolades">
		<div class="container">
			<div class="row">
				<h2>Accreditation and Accolades</h2>
				<button type="button" role="presentation" class="accolades__nav accolades__nav--prev" aria-label="Previous">‹</button>
				<div class="accolades__wrap accolades__wrap--x<?php echo esc_html( $awards_count ); ?>">
					<?php
					foreach ( $awards as $award ) {
						$award = is_int( $award ) ? wp_get_attachment_url( $award ) : $award;
						?>
						<div class="accolade">
							<img src="<?php echo esc_url( $award ); ?>" />
						</div>
						<?php
					}
					?>
				</div>
				<button type="button" role="presentation" class="accolades__nav accolades__nav--next" aria-label="Next">›</a>
			</div>
		</div>
	</section>

	<?php
}
