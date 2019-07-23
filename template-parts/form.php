<?php
/**
 * Template for Displaying Form
 *
 * @package info.*.edu
 */

$page_id         = get_the_ID();
$gform_id        = get_post_meta( $page_id, 'gravity_forms', true );
$form_intro_text = get_post_meta( $page_id, 'form_cta', true );

// IF no form is selected.
if ( ! $gform_id ) {
	$gform_id = get_theme_mod( 'rfi_sidebar_form_id' );
}

// IF no intro text is provided.
if ( ! $form_intro_text ) {
	$form_intro_text = get_theme_mod( 'form_intro' );
}
?>
<div class="info-section__form" id="page-form">
	<div class="form__inner">
		<?php
		echo '<div class="form__intro">' . wp_kses_post( $form_intro_text ) . '</div>';

		if ( function_exists( 'gravity_form' ) ) {
			gravity_form( $gform_id, false, false, false, null, true );
		}
		?>
	</div>
</div>
