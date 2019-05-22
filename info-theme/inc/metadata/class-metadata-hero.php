<?php
/**
 * Holds our Metadata_Hero class
 */

/**
 * Metadata_Hero
 */
class Metadata_Hero {
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
		$fm = new Fieldmanager_Group( array(
			'name'           => 'hero_fields', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => array(
				self::$prefix . 'headline'      => new Fieldmanager_RichTextArea( 'Main Headline', array(
					'buttons_1'       => array( 'bold', 'italic', 'strikethrough' ),
					'editor_settings' => array(
						'media_buttons' => false,
					),
				) ),
				self::$prefix . 'subheadline'   => new Fieldmanager_RichTextArea( 'Sub Headline', array(
					'buttons_1'       => array( 'bold', 'italic', 'strikethrough' ),
					'editor_settings' => array(
						'media_buttons' => false,
					),
				) ),
				self::$prefix . 'background'    => new Fieldmanager_TextField( 'Background Image', array(
					'description' => 'Disabled on purpose. Do not use this field, use the page Featured Image to set the hero.',
					'attributes'  => array(
						'style'    => 'width:100%;',
						'disabled' => 'disabled',
					),
				) ),
				self::$prefix . 'student_info'  => new Fieldmanager_TextField( 'Student\'s Name and Class Year', array(
					'description' => 'First name and last initial only + class year. "Karla D., Class of 2014"',
				) ),
				self::$prefix . 'student_title' => new Fieldmanager_TextField( 'Student\'s Title', array(
					'description' => 'Veteran status or program pursued. (Will be hidden if left blank)',
				) ),
			),
		) );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Hero', 'page' );
	}
}
