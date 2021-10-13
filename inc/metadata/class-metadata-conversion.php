<?php
/**
 * Holds our Metadata_Conversion class
 *
 * - Convert metadata structure from Fieldmanager to CMB2 on CMB2 plugin activation.
 * - Hold backwards compatibility for Fieldmanager.
 */

/**
 * Metadata_Conversion
 */
class Metadata_Conversion {
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
		add_action( 'activate_cmb2/init.php', [ $this, 'convert_data' ] );

		if ( is_plugin_active( 'cmb2/init.php' ) ) {
			return;
		}

		self::$prefix = '_nus_template_';

		add_action( 'fm_post_page', [ $this, 'register_phonenumber_metabox' ] );
		add_action( 'fm_post_page', [ $this, 'register_content_metabox' ] );
		add_action( 'fm_post_page', [ $this, 'register_hero_metabox' ] );
		add_action( 'fm_post_page', [ $this, 'register_quote_metabox' ] );
		add_action( 'fm_post_page', [ $this, 'register_layout_metabox' ] );
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
	 * Convert metadata structure from Fieldmanager to CMB2 on CMB2 plugin activation.
	 *
	 * @return void
	 */
	public function convert_data() {
		global $wpdb;

		$awards_lists = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = %s", '_awards_list' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		foreach ( $awards_lists as $awards_list ) {
			$list = maybe_unserialize( $awards_list->meta_value );

			if ( empty( $list ) ) {
				delete_post_meta( $awards_list->post_id, $awards_list->meta_key );
			} elseif ( is_array( $list ) && count( $list ) === count( array_filter( $list, 'is_numeric' ) ) ) {
				$new_meta_value = [];
				foreach ( $list as $award_id ) {
					$new_meta_value[ $award_id ] = wp_get_attachment_url( $award_id );
				}

				update_post_meta( $awards_list->post_id, '_awards_list', $new_meta_value );
			}
		}

		$quote_images = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = %s", '_quote_image' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		foreach ( $quote_images as $quote_image ) {
			if ( empty( $quote_image->meta_value ) ) {
				delete_post_meta( $quote_image->post_id, $quote_image->meta_key );
			} elseif ( is_numeric( $quote_image->meta_value ) ) {
				$image_id = $quote_image->meta_value;
				update_post_meta( $quote_image->post_id, '_quote_image_id', $image_id );
				update_post_meta( $quote_image->post_id, '_quote_image', wp_get_attachment_url( $image_id ) );
			}
		}
	}

	/**
	 * Here for backwards compatability for our sites with Fieldmanager plugin.
	 *
	 * @return void
	 */
	public function register_phonenumber_metabox() {
		$fm = new Fieldmanager_TextField( [
			'name'        => '_page_contact_phone_number', // "name" id deceiving, used as the key/ID.
			'label'       => 'Phone Number',
			'description' => 'Override the phone number in the header. Format: 855-355-6288.',
			'attributes'  => [
				'type'    => 'tel',
				'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
			],
		] );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Header', 'page', 'side', 'low' );
	}

	/**
	 * Here for backwards compatability for our sites with Fieldmanager plugin.
	 *
	 * @return void
	 */
	public function register_content_metabox() {
		$fm = new Fieldmanager_Group( [
			'name'           => 'content_fields', // "name" id deceiving, used as the key/ID.
			'add_to_prefix'  => false,
			'serialize_data' => false,
			'tabbed'         => 'vertical',
			'children'       => [
				'_columns'     => new Fieldmanager_RichTextArea( [
					'label'           => 'Content Columns',
					'limit'           => 2,
					'description'     => 'If using an initial heading, use an H2 tag and add ID attribute "content-area-{column number}. e.g. id="content-area-1. If using main WYSIWYG, offset column # by 1.',
					'add_more_label'  => 'Add column',
					'editor_settings' => [
						'media_buttons' => false,
						'editor_height' => 200,
					],
				] ),
				'_callout'     => new Fieldmanager_RichTextArea( [
					'label'       => 'Custom Callout Box',
					'description' => 'Must follow: <img><h3>Title</h3><p>Content</p>',
				] ),
				'_awards_list' => new Fieldmanager_Media( [
					'label'          => 'Awards',
					'description'    => 'Logos: Choose two - up to four.',
					'limit'          => 4,
					'add_more_label' => 'Add another image',
				] ),
			],
		] );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Content', 'page' );
	}

	/**
	 * Here for backwards compatability for our sites with Fieldmanager plugin.
	 *
	 * @return void
	 */
	public function register_hero_metabox() {
		$fm = new Fieldmanager_Group( [
			'name'           => 'hero_fields', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'_headline'    => new Fieldmanager_RichTextArea( 'Main Headline', [
					'buttons_1'       => [ 'bold', 'italic', 'strikethrough' ],
					'editor_settings' => [
						'media_buttons' => false,
					],
				] ),
				'_subheadline' => new Fieldmanager_RichTextArea( 'Sub Headline', [
					'buttons_1'       => [ 'bold', 'italic', 'strikethrough' ],
					'editor_settings' => [
						'media_buttons' => false,
					],
				] ),
			],
		] );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Hero', 'page' );
	}

	/**
	 * Here for backwards compatability for our sites with Fieldmanager plugin.
	 *
	 * @return void
	 */
	public function register_quote_metabox() {
		$fm = new Fieldmanager_Group( [
			'name'           => 'quote_fields', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'_quote_text'     => new Fieldmanager_TextField( 'Quote Text', [
					'description' => 'Limited to 150 characters due to design constrictions.',
					'attributes'  => [
						'maxlength' => 150,
						'size'      => 150,
					],
				] ),
				'_quote_citation' => new Fieldmanager_TextField( 'Quotee', [
					'description' => 'Limited to 50 characters due to design constrictions.',
					'attributes'  => [
						'maxlength' => 50,
						'size'      => 50,
					],
				] ),
				'_quote_title'    => new Fieldmanager_TextField( 'Quotee\'s Title', [
					'description' => 'Limited to 50 characters due to design constrictions.<br>If left blank, title block will be hidden.',
					'attributes'  => [
						'maxlength' => 50,
						'size'      => 50,
					],
				] ),
				'_quote_image'    => new Fieldmanager_Media( 'Quotee\'s Headshot', [
					'description' => 'Please limit to an image no wider or taller than 300px each.',
				] ),
			],
		] );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Quote', 'page' );
	}

	/**
	 * Register our metabox with all our fields
	 *
	 * Here for backwards compatability for our sites with Fieldmanager plugin.
	 *
	 * @return void
	 */
	public function register_layout_metabox() {
		$degree_types = taxonomy_exists( 'degree-type' ) ? new Fieldmanager_Datasource_Term( [
			'taxonomy' => 'degree-type',
		] ) : new stdClass();
		$degree_types = method_exists( $degree_types, 'get_items' ) ? $degree_types->get_items() : [];

		$areas_of_study = taxonomy_exists( 'area-of-study' ) ? new Fieldmanager_Datasource_Term( [
			'taxonomy' => 'area-of-study',
		] ) : new stdClass();
		$areas_of_study = method_exists( $areas_of_study, 'get_items' ) ? $areas_of_study->get_items() : [];

		$class_formats = taxonomy_exists( 'class-format' ) ? new Fieldmanager_Datasource_Term( [
			'taxonomy' => 'class-format',
		] ) : new stdClass();
		$class_formats = method_exists( $class_formats, 'get_items' ) ? $class_formats->get_items() : [];

		$degrees = new Fieldmanager_Datasource_Post( [
			'query_args' => [
				'post_type'      => 'program',
				'posts_per_page' => -1,
			],
		] );
		$degrees = ! empty( $degrees->get_items() ) ? $degrees->get_items() : [];

		$fm = new Fieldmanager_Group( [
			'name'           => 'form_landing', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				self::$prefix . 'form_type'     => new Fieldmanager_Radios( 'Form Type', [
					'description' => 'Would you like a Program selection? A Program and Degree selection? or neither?. NOTE:  Save the page to see other fields.',
					'options'     => [
						'brand'   => __( 'Brand Specific', 'nusa' ),
						'area'    => __( 'Area of Study Specific', 'nusa' ),
						'program' => __( 'Program Specific', 'nusa' ),
					],
				] ),
				self::$prefix . 'degree_type'   => new Fieldmanager_Checkboxes( 'Degree Type', [
					'description' => 'You may choose multiple degree types.',
					'options'     => $degree_types,
					'attributes'  => [
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( [ 'area', 'program' ] ),
					],
				] ),
				self::$prefix . 'area_of_study' => new Fieldmanager_Radios( 'Area of Study', [
					'description' => 'You may only choose one.',
					'options'     => $areas_of_study,
					'attributes'  => [
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( [ 'area', 'program' ] ),
					],
				] ),
				self::$prefix . 'class_format'  => new Fieldmanager_Checkboxes( 'Class Format', [
					'description' => 'All Classes are offered on campus.',
					'options'     => $class_formats,
					'attributes'  => [
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( [ 'area', 'program' ] ),
					],
				] ),
				self::$prefix . 'degrees'       => new Fieldmanager_Checkboxes( 'Select Degree(s)', [
					'description_after_element' => false,
					'options'                   => $degrees,
					'attributes'                => [
						'data-conditional-id'    => self::$prefix . 'form_type',
						'data-conditional-value' => wp_json_encode( [ 'area', 'program' ] ),
					],
				] ),
			],
		] );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Select Programs for Form Dropdown', 'page' );
	}
}
