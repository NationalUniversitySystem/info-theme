<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

// First two widgets.
$columns = get_post_meta( get_the_ID(), '_columns', true );
if ( empty( $columns ) ) {
	get_theme_mod( 'why_choose' ) ? $columns[] = get_theme_mod( 'why_choose' ) : '';
}

// Widget with border.
$custom_callout = get_post_meta( get_the_ID(), '_callout', true );
$callout_text   = ! empty( $custom_callout ) ? $custom_callout : get_theme_mod( 'callout' );

// If all widgets are blank, don't show any markup, bail on this template part.
if ( empty( $columns ) && empty( $callout_text ) ) {
	return;
}
?>
<section class="section section--widgets">
	<div class="container p-7">
		<div class="row">
			<?php
			if ( $columns ) {
				foreach ( $columns as $column ) {
					?>
					<div class="widget col-12 col-sm-6 col-lg-4 mb-5">
						<?php echo wp_kses_post( $column ); ?>
					</div>
					<?php
				};
			}

			if ( $callout_text ) {
				?>
				<div class="widget widget--alt col-12 col-lg-4 p-5 d-md-flex flex-lg-wrap align-items-md-center align-content-lg-center">
					<?php echo wp_kses_post( $callout_text ); ?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
