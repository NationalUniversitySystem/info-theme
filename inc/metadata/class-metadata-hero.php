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
	 * Using construct function to add any actions and filters
	 */
	public function __construct() {
		add_action( 'fm_post', [ $this, 'register_metabox' ] );
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
}
