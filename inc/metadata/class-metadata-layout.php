<?php
/**
 * Holds our Metadata_Layout class
 */

/**
 * Metadata_Layout
 */
class Metadata_Layout {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Prefix used for the metadata
	 *
	 * @var string
	 */
	public static $prefix;

	/**
	 * Using construct function to add any actions and filters
	 */
	public function __construct() {
		// Start with an underscore to hide fields from custom fields list.
		self::$prefix = '_nus_template_';

		add_action( 'cmb2_admin_init', [ $this, 'register_metabox' ] );
	}

	/**
	 * Singleton
	 *
	 * Returns a single instance of the current class.
	 */
	public static function singleton() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register our metabox with all our fields
	 *
	 * @return void
	 */
	public function register_metabox() {
		$cmb = new_cmb2_box( [
			'id'           => 'form_landing',
			'title'        => 'Select Programs for Form Dropdown',
			'object_types' => [ 'page' ],
		] );

		$cmb->add_field( [
			'id'      => self::$prefix . 'form_type',
			'name'    => 'Form Type',
			'desc'    => 'Would you like a Program selection? A Program and Degree selection? or neither?. NOTE:  Save the page to see other fields.',
			'type'    => 'radio_inline',
			'options' => [
				'brand'   => __( 'Brand Specific', 'nusa' ),
				'area'    => __( 'Area of Study Specific', 'nusa' ),
				'program' => __( 'Program Specific', 'nusa' ),
			],
		] );

		$cmb->add_field( [
			'id'       => self::$prefix . 'degree_type',
			'name'     => 'Degree Type',
			'desc'     => 'You may choose multiple degree types.',
			'type'     => 'taxonomy_multicheck',
			'taxonomy' => 'degree-type',
		] );

		$cmb->add_field( [
			'id'               => self::$prefix . 'area_of_study',
			'name'             => 'Area of Study',
			'desc'             => 'You may only choose one.',
			'type'             => 'taxonomy_radio',
			'taxonomy'         => 'area-of-study',
			'show_option_none' => false,
		] );

		$cmb->add_field( [
			'id'       => self::$prefix . 'class_format',
			'name'     => 'Class Format',
			'desc'     => 'All Classes are offered on campus.',
			'type'     => 'taxonomy_multicheck_inline',
			'taxonomy' => 'class-format',
		] );

		$degrees = new WP_Query( [
			'post_type'      => 'program',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		] );

		$cmb->add_field( [
			'id'      => self::$prefix . 'degrees',
			'name'    => 'Select Degree(s)',
			'type'    => 'multicheck',
			'options' => wp_list_pluck( $degrees->posts, 'post_title', 'ID' ),
		] );
	}
}
