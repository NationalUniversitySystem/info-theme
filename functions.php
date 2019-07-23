<?php
/**
 * NUSA functions and definitions
 *
 * @package nusa
 */

/**
 * Require and initiate our classes.
 */
require get_template_directory() . '/inc/class-nusa-theme-setup.php';
require get_template_directory() . '/inc/class-nusa-widgets.php';

/**
 * Forms setup.
 */
require get_template_directory() . '/inc/forms/class-theme-gravity-forms.php';
require get_template_directory() . '/inc/forms/class-form-dynamic-population.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/class-skyrocket-tinymce-custom-control.php';
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/class-nu-customizer-global-forms.php';
require get_template_directory() . '/inc/customizer/class-nu-customizer-global-column.php';
require get_template_directory() . '/inc/customizer/class-nu-customizer-site-globals.php';

/**
 * Metadata
 */
require_once get_template_directory() . '/inc/metadata/class-metadata-hero.php';
require_once get_template_directory() . '/inc/metadata/class-metadata-quote.php';
require_once get_template_directory() . '/inc/metadata/class-metadata-content.php';
require_once get_template_directory() . '/inc/metadata/class-metadata-layout.php';
require_once get_template_directory() . '/inc/metadata/class-metadata-contact-number.php';

/**
 * Initiate classes
 */
// Theme.
NUSA_Theme_Setup::singleton();
NUSA_Widgets::singleton();

// Forms.
Theme_Gravity_Forms::singleton();
Form_Dynamic_Population::singleton();

Nu_Customizer_Global_Forms::singleton();
Nu_Customizer_Global_Column::singleton();
Nu_Customizer_Site_Globals::singleton();

// Metadata.
Metadata_Hero::singleton();
Metadata_Quote::singleton();
Metadata_Content::singleton();
Metadata_Layout::singleton();
Metadata_Contact_Number::singleton();

add_action( 'after_setup_theme', array( 'NUSA_Theme_Setup', 'set_theme_options' ) );

/**
 * Stop WYSIWYG editor from removing spans
 *
 * @param array $init_array An array with TinyMCE config.
 * @return array
 */
function override_mce_options( $init_array ) {
	$opts = '*[*]';

	$init_array['valid_elements']          = $opts;
	$init_array['extended_valid_elements'] = $opts;

	return $init_array;
}

add_filter( 'tiny_mce_before_init', 'override_mce_options' );

/**
 * Get the campaignActivity input value
 *
 * @param array $metadata List of metadata.
 * @return mixed
 */
function get_campaign_activity( $metadata = null ) {
	global $post;

	// Just in case the function is called without the post/page metadata.
	if ( null === $metadata ) {
		// Using our custom get_meta function so that single values aren't inside an array.
		$metadata = get_all_meta( $post->ID );
	}

	// Fallback.
	$default_value = 'brand';

	$form_type = ! empty( $metadata['_nus_template_form_type'] ) ? $metadata['_nus_template_form_type'] : 'brand';

	// Get the parents of the page (if any).
	$ancestors = get_post_ancestors( $post->ID );

	// If there was parents (not top level page) then set up the default.
	if ( ! empty( $ancestors ) ) {
		$root          = count( $ancestors ) - 1;
		$top_parent_id = $ancestors[ $root ];

		$parent_campaign_activity = get_post_meta( $top_parent_id, '_nus_template_form_campaign_activity', true );

		if ( empty( $parent_campaign_activity ) ) {
			$top_parent_obj = get_post( $top_parent_id );

			$default_value = substr( $top_parent_obj->post_name, 0, 3 );
		} else {
			$default_value = $parent_campaign_activity;
		}
	} elseif ( 'brand' === $form_type ) {
		$default_value = 'brand';
	} else {
		$default_value = substr( $post->post_name, 0, 3 );
	}

	return $default_value;
}

/**
 * Get All Meta
 *
 * Utility function used to consolidate the querying of multiple meta values
 * for the given object.
 *
 * @param int      $post_id ID of the current object.
 * @param mixed    $fields  Array/string containing meta field(s) to retrieve from database.
 * @param string   $type    Type of metadata request. Options: post/term/user.
 * @param constant $output  Pre-defined constant for return type (OBJECT/ARRAY_A).
 *
 * @return mixed    MySQL object/Associative Array containing returned post metadata.
 */
function get_all_meta( $post_id = null, $fields = array(), $type = 'post', $output = ARRAY_A ) {

	$meta_data = get_post_meta( $post_id );

	$meta_data = array_map( function( $n ) {
		return maybe_unserialize( $n[0] );
	}, $meta_data );

	return $meta_data;
}
