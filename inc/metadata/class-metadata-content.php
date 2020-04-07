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
	 * Using construct function to add any actions and filters
	 */
	public function __construct() {
		add_action( 'fm_post_page', [ $this, 'register_metabox' ] );
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
		$fm = new Fieldmanager_Group( [
			'name'           => 'content_fields', // "name" id deceiving, used as the key/ID.
			'add_to_prefix'  => false,
			'serialize_data' => false,
			'tabbed'         => 'vertical',
			'children'       => [
				'_columns'     => new Fieldmanager_RichTextArea( [
					'label'           => 'Content Columns',
					'limit'           => 2,
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
}
