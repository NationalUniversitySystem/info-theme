<?php
/**
 * Holds the variables used across tamplat parts
 */

$page_id = get_the_ID();

/**
 * Forms
 */
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

/**
 * COLUMNS
 */
$columns           = get_post_meta( $page_id, '_nus_template_columns', true );
$global_why_choose = get_theme_mod( 'why_choose' );
$custom_callout    = get_post_meta( $page_id, '_nus_template_callout', true );
$global_callout    = get_theme_mod( 'callout' );

/**
 * QUOTE
 */
$quote_text     = get_post_meta( $page_id, '_nus_template_quote_text', true );
$quote_citation = get_post_meta( $page_id, '_nus_template_quote_citation', true );
$quote_title    = get_post_meta( $page_id, '_nus_template_quote_title', true );
