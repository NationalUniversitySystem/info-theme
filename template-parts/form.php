<?php
/**
 * Template for Displaying Form
 *
 * @package info.*.edu
 */

$page_id         = get_the_ID();
$gform_id        = get_post_meta( $page_id, 'page_form_id', true );
$form_intro_text = get_post_meta( $page_id, 'form_cta', true );

// Replace form ID with global ID if the page one was empty.
$gform_id = $gform_id ? $gform_id : get_theme_mod( 'rfi_sidebar_form_id' );

// Same for lead-in text.
$form_intro_text = $form_intro_text ? $form_intro_text : get_theme_mod( 'form_intro' );
?>
<div class="section__form col-12 col-lg-4 pl-md-0" id="page-form">
	<div class="form__inner">
		<div class="form__intro"><?php echo wp_kses_post( $form_intro_text ); ?></div>
		<?php
		if ( function_exists( 'gravity_form' ) ) {
			gravity_form( $gform_id, false, false, false, null, true );
		}
		?>
	</div>
</div>
