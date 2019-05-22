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

		add_action( 'fm_post', array( $this, 'register_metabox' ) );
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
	 * Register our metabox with all out fields
	 *
	 * @return void
	 */
	public function register_metabox() {
		$degree_types = taxonomy_exists( 'degree-type' ) ? new Fieldmanager_Datasource_Term( array(
			'taxonomy' => 'degree-type',
		) ) : new stdClass();
		$degree_types = method_exists( $degree_types, 'get_items' ) ? $degree_types->get_items() : array();

		$areas_of_study = taxonomy_exists( 'area-of-study' ) ? new Fieldmanager_Datasource_Term( array(
			'taxonomy' => 'area-of-study',
		) ) : new stdClass();
		$areas_of_study = method_exists( $areas_of_study, 'get_items' ) ? $areas_of_study->get_items() : array();

		$class_formats = taxonomy_exists( 'class-format' ) ? new Fieldmanager_Datasource_Term( array(
			'taxonomy' => 'class-format',
		) ) : new stdClass();
		$class_formats = method_exists( $class_formats, 'get_items' ) ? $class_formats->get_items() : array();

		$degrees = new Fieldmanager_Datasource_Post( array(
			'query_args' => array(
				'post_type'      => 'program',
				'posts_per_page' => -1,
			),
		) );
		$degrees = ! empty( $degrees->get_items() ) ? $degrees->get_items() : array();

		$fm = new Fieldmanager_Group( array(
			'name'           => 'form_landing', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => array(
				self::$prefix . 'form_type'     => new Fieldmanager_Radios( 'Form Type', array(
					'description' => 'Would you like a Program selection? A Program and Degree selection? or neither?. NOTE:  Save the page to see other fields.',
					'options'     => array(
						'brand'   => __( 'Brand Specific', 'nus' ),
						'area'    => __( 'Area of Study Specific', 'nus' ),
						'program' => __( 'Program Specific', 'nus' ),
					),
				) ),
				self::$prefix . 'degree_type'   => new Fieldmanager_Checkboxes( 'Degree Type', array(
					'description' => 'You may choose multiple degree types.',
					'options'     => $degree_types,
					'attributes'  => array(
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( array( 'area', 'program' ) ),
					),
				) ),
				self::$prefix . 'area_of_study' => new Fieldmanager_Radios( 'Area of Study', array(
					'description' => 'You may only choose one.',
					'options'     => $areas_of_study,
					'attributes'  => array(
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( array( 'area', 'program' ) ),
					),
				) ),
				self::$prefix . 'class_format'  => new Fieldmanager_Checkboxes( 'Class Format', array(
					'description' => 'All Classes are offered on campus.',
					'options'     => $class_formats,
					'attributes'  => array(
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( array( 'area', 'program' ) ),
					),
				) ),
				self::$prefix . 'degrees'       => new Fieldmanager_Checkboxes( 'Select Degree(s)', array(
					'description_after_element' => false,
					'options'                   => $degrees,
					'attributes'                => array(
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( array( 'area', 'program' ) ),
					),
				) ),
			),
		) );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Select Programs for Form Dropdown', 'page' );
	}
}
