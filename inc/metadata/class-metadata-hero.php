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
			'id'           => 'hero_fields',
			'title'        => 'Hero',
			'object_types' => [ 'page' ],
		] );

		$cmb->add_field( [
			'id'      => '_headline',
			'name'    => 'Main Headline',
			'type'    => 'wysiwyg',
			'options' => [
				'media_buttons' => false,
				'textarea_rows' => 5,
			],
		] );

		$cmb->add_field( [
			'id'      => '_subheadline',
			'name'    => 'Sub Headline',
			'type'    => 'wysiwyg',
			'options' => [
				'media_buttons' => false,
				'textarea_rows' => 5,
			],
		] );
	}
}
