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
			'id'           => 'content_fields',
			'title'        => 'Content',
			'object_types' => [ 'page' ],
		] );

		$cmb->add_field( [
			'id'         => '_columns',
			'name'       => 'Content Columns',
			'desc'       => 'If using an initial heading, use an H2 tag and add ID attribute "content-area-{column number}. e.g. id="content-area-1. If using main WYSIWYG, offset column # by 1.',
			'type'       => 'textarea',
			'repeatable' => true,
			'text'       => [
				'add_row_text' => 'Add column',
			],
		] );

		$cmb->add_field( [
			'id'   => '_callout',
			'name' => 'Custom Callout Box',
			'desc' => htmlspecialchars( 'Must follow: <img><h3>Title</h3><p>Content</p>' ),
			'type' => 'wysiwyg',
		] );

		$cmb->add_field( [
			'id'           => '_awards_list',
			'name'         => 'Awards',
			'desc'         => 'Logos: Choose two - up to four.',
			'type'         => 'file_list',
			'preview_size' => [ 100, 100 ],
		] );
	}
}
