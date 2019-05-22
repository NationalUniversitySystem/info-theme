<?php
/**
 * Set up Outreach form manipulation
 *
 * @package nusa
 */

/**
 * Outreach_Form class
 */
class Outreach_Form {
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
		add_action( 'init', array( $this, 'add_outreach_endpoint' ) );
		add_action( 'template_redirect', array( $this, 'outreach_template_redirect' ) );
		add_filter( 'body_class', array( $this, 'add_split_class' ) );
		add_action( 'wp_head', array( $this, 'add_web_app_capable_meta' ) );
	}

	/**
	 * Singleton
	 *
	 * Returns a single instance of this class.
	 */
	public static function singleton() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add a custom endpoint for when visiting from "/outreach/{ipad_number}/"
	 *
	 * @return void
	 */
	public function add_outreach_endpoint() {
		add_rewrite_endpoint( 'outreach', EP_ROOT );
	}

	/**
	 * Make sure the "/outreach/{ipad_number}/"" visitors all display the right template
	 *
	 * @return void
	 */
	public function outreach_template_redirect() {
		global $wp_query;

		if ( ! isset( $wp_query->query_vars['outreach'] ) ) {
			return;
		}

		if ( file_exists( get_template_directory() . '/page-templates/split-50.php' ) ) {
			include get_template_directory() . '/page-templates/split-50.php';
			exit;
		}
	}

	/**
	 * Add the split-50 body class manually when doing the template redirect.
	 *
	 * @param array $classes An array of class names.
	 *
	 * @return array
	 */
	public function add_split_class( $classes ) {
		global $wp_query;

		if ( isset( $wp_query->query_vars['outreach'] ) ) {
			$classes[] = 'page-template-split-50';
		}

		return $classes;
	}

	/**
	 * Add the meta tag responsible for iOS web app capable
	 * - Removes the nav URL/status bar from the pop up.
	 *
	 * @return void
	 */
	public function add_web_app_capable_meta() {
		global $wp_query;
		if ( isset( $wp_query->query_vars['outreach'] ) ) {
			echo '<meta name="apple-mobile-web-app-capable" content="yes" />' . "\n";
		}
	}
}
