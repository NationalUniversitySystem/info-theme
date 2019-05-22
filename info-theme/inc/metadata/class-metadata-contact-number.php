<?php
/**
 * Holds our Metadata_Contact_Number class
 */

/**
 * Metadata_Contact_Number
 */
class Metadata_Contact_Number {
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
		$fm = new Fieldmanager_TextField( array(
			'name'        => '_page_contact_phone_number', // "name" id deceiving, used as the key/ID.
			'label'       => 'Phone Number',
			'description' => 'Override the phone number in the header. Format: 855-355-6288.',
			'attributes'  => array(
				'type'    => 'tel',
				'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
			),
		) );

		/**
		 * Initiate the metabox
		 */
		$fm->add_meta_box( 'Header', 'page', 'side', 'low' );
	}
}
