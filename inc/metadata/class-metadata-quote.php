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
			'id'           => 'quote_fields',
			'title'        => 'Quote',
			'object_types' => [ 'page' ],
		] );

		$cmb->add_field( [
			'id'         => '_quote_text',
			'name'       => 'Quote Text',
			'desc'       => 'Limited to 150 characters due to design constrictions.',
			'type'       => 'text',
			'attributes' => [
				'maxlength' => 150,
				'size'      => 150,
			],
		] );

		$cmb->add_field( [
			'id'         => '_quote_citation',
			'name'       => 'Quotee',
			'desc'       => 'Limited to 50 characters due to design constrictions.',
			'type'       => 'text',
			'attributes' => [
				'maxlength' => 50,
				'size'      => 50,
			],
		] );

		$cmb->add_field( [
			'id'         => '_quote_title',
			'name'       => 'Quotee\'s Title',
			'desc'       => 'Limited to 50 characters due to design constrictions.<br>If left blank, title block will be hidden.',
			'type'       => 'text',
			'attributes' => [
				'maxlength' => 50,
				'size'      => 50,
			],
		] );

		$cmb->add_field( [
			'id'         => '_quote_image',
			'name'       => 'Quotee\'s Headshot',
			'desc'       => 'Please limit to an image no wider or taller than 300px each.',
			'type'       => 'file',
			'options'    => [
				'url' => false,
			],
			'query_args' => [
				'type' => [
					'image/jpeg',
					'image/png',
				],
			],
		] );
	}
}
