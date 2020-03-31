<?php
/**
 * Settings globally set for the site | Set up for WP Customizer
 *
 * @package national-university
 */

/**
 * Nu_Customizer_Site_Globals class
 */
class Nu_Customizer_Site_Globals {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Use class construct method to define all filters & actions
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'register_settings' ], 99 );
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
	 * Add custom section to the WP Customizer for this class
	 *
	 * @param object $wp_customize WP_Customize_Manager.
	 *
	 * @return void
	 */
	public function register_settings( $wp_customize ) {
		$wp_customize->add_setting( 'contact_phone_number' );

		$wp_customize->add_control( 'contact_phone_number', [
			'label'       => __( 'Phone number' ),
			'description' => __( 'Main phone number for display in the hero. Can be overwritten on a page level.<br>Format: 855-355-6288' ),
			'section'     => 'title_tagline',
			'type'        => 'tel',
			'input_attrs' => [
				'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
			],
		] );
	}
}
