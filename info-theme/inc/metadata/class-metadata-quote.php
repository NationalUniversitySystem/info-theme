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
		$fm = new Fieldmanager_Group( array(
			'name'           => 'quote_fields', // "name" id deceiving, used as the key/ID.
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => array(
				self::$prefix . 'quote_text'     => new Fieldmanager_TextField( 'Quote Text', array(
					'description' => 'Limited to 150 characters due to design constrictions.',
					'attributes'  => array(
						'maxlength' => 150,
						'size'      => 150,
					),
				) ),
				self::$prefix . 'quote_citation' => new Fieldmanager_TextField( 'Quotee', array(
					'description' => 'Limited to 50 characters due to design constrictions.',
					'attributes'  => array(
						'maxlength' => 50,
						'size'      => 50,
					),
				) ),
				self::$prefix . 'quote_title'    => new Fieldmanager_TextField( 'Quotee\'s Title', array(
					'description' => 'Limited to 50 characters due to design constrictions.<br>If left blank, title block will be hidden.',
					'attributes'  => array(
						'maxlength' => 50,
						'size'      => 50,
					),
				) ),
			),
		) );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Quote', 'page' );
	}
}
