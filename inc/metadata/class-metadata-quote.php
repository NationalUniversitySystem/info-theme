<?php
/**
 * Holds our Metadata_Quote class
 */

/**
 * Metadata_Quote
 */
class Metadata_Quote {
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
}
