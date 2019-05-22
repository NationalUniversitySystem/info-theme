<?php
/**
 * Holds our Metadata_Content class
 */

/**
 * Metadata_Content
 */
class Metadata_Content {
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

		add_action( 'fm_post_page', array( $this, 'register_metabox' ) );
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
		$award_images  = glob( get_template_directory() . '/images/page-builder/awards/*.png' );
		$award_options = array();

		foreach ( $award_images as $image ) {
			$image_parts = pathinfo( $image );
			$image_url   = get_template_directory_uri() . '/images/page-builder/awards/' . $image_parts['basename'];

			$award_options[ $image_url ] = $image_url;
		}

		$fm = new Fieldmanager_Group( array(
			'name'           => 'content_fields', // "name" id deceiving, used as the key/ID.
			'add_to_prefix'  => false,
			'serialize_data' => false,
			'tabbed'         => 'horizontal',
			'children'       => array(
				self::$prefix . 'columns'     => new Fieldmanager_Group( array(
					'label'         => 'Content Columns',
					'add_to_prefix' => false,
					'limit'         => 2,
					'children'      => array(
						'content' => new Fieldmanager_RichTextArea( 'Column', array(
							'editor_settings' => array(
								'media_buttons' => false,
								'editor_height' => 200,
							),
						) ),
					),
				) ),
				self::$prefix . 'callout'     => new Fieldmanager_RichTextArea( array(
					'label'       => 'Custom Callout Box',
					'description' => 'Must follow: <img><h3>Title</h3><p>Content</p>',
				) ),
				self::$prefix . 'awards_list' => new Fieldmanager_Media( array(
					'label'          => 'Awards',
					'description'    => 'Logos: Choose two - up to four.',
					'limit'          => 4,
					'add_more_label' => 'Add another image',
				) ),
				self::$prefix . 'awards'      => new Fieldmanager_Checkboxes( array(
					'label'       => 'Awards - Compatibility',
					'description' => 'Logos: Choose two - up to four.',
					'options'     => $award_options,
					'attributes'  => array(
						'disabled' => 'disabled',
					),
				) ),
			),
		) );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Content', 'page' );
	}
}
