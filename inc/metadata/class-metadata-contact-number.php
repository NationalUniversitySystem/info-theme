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
			'id'           => 'header_metabox',
			'title'        => 'Header',
			'object_types' => [ 'page' ],
			'context'      => 'side',
			'priority'     => 'low',
			'show_names'   => true,
		] );

		$cmb->add_field( [
			'id'         => '_page_contact_phone_number',
			'name'       => 'Phone Number',
			'desc'       => 'Override the phone number in the header. Format: 855-355-6288.',
			'type'       => 'text',
			'attributes' => [
				'type'    => 'tel',
				'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
			],
		] );
	}
}
