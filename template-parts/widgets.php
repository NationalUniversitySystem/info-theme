<?php
/**
 * Template for Displaying Widgets
 *
 * @package info.*.edu
 */

// First two widgets.
$columns = get_post_meta( get_the_ID(), '_columns', true );
if ( empty( $columns ) && get_theme_mod( 'why_choose' ) ) {
	$columns[] = get_theme_mod( 'why_choose' );
}

// Widget with border.
$custom_callout = get_post_meta( get_the_ID(), '_callout', true );
$callout_text   = ! empty( $custom_callout ) ? $custom_callout : get_theme_mod( 'callout' );

// If all widgets are blank, don't show any markup, bail on this template part.
if ( empty( $columns ) && empty( $callout_text ) ) {
	return;
}
?>
<section class="section section--widgets px-md-0 px-1">
	<div class="container py-md-7 px-xl-4 px-md-8 px-8">
		<div class="row">
			<?php
			if ( $columns ) {
				$column_offset = trim( get_the_content( null, false, get_the_ID() ) ) ? 2 : 1;

				foreach ( $columns as $key => $column ) {
					?>
					<article class="widget col-12 col-sm-6 col-lg-4 mb-5" aria-labelledby="Content area #<?php echo esc_attr( $key + $column_offset ); ?>">
						<?php echo wp_kses_post( $column ); ?>
					</article>
					<?php
				};
			}

			if ( $callout_text ) {
				?>
				<article class="widget widget--alt col-12 col-lg-4 pl-lg-0" aria-label="Callout area">
					<?php echo wp_kses_post( $callout_text ); ?>
				</article>
				<?php
			}
			?>
		</div>
	</div>
</section>
