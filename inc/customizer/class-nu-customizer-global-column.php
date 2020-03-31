<?php
/**
 * Set up theme Global Columns management in customizer
 *
 * @package national-university
 */

/**
 * Nu_Customizer_Global_Columns class
 */
class Nu_Customizer_Global_Column {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Forms for each method/setting to use
	 *
	 * @var array
	 */
	public $forms = [];

	/**
	 * Using construct function to add any actions and filters associated with the CPT
	 */
	public function __construct() {
		add_action( 'customize_register', [ $this, 'add_global_column_section' ] );
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
	 * Add the Global Columns panel
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_global_column_section( $wp_customize = null ) {
		// CUSTOM FORMS PANEL.
		$wp_customize->add_panel( 'column_options', [
			'priority'   => 10,
			'title'      => __( 'Global Columns', 'national-university' ),
			'capability' => 'edit_theme_options',
		] );

		$this->add_column_section( $wp_customize );
	}

	/**
	 * Add the Terms & Condition section, setting, and control
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_column_section( $wp_customize = null ) {

		// FORMS CONTENT PANEL.
		$wp_customize->add_section( 'callout_section', [
			'title'      => __( 'Global Callout Column' ),
			'panel'      => 'column_options',
			'capability' => 'edit_theme_options',
		] );

		// TERMS & CONDITIONS.
		$wp_customize->add_setting( 'callout', [
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		] );

		$wp_customize->add_control(
			new Skyrocket_TinyMCE_Custom_Control(
				$wp_customize,
				'callout',
				[
					'label'       => __( 'Global Callout HTML' ),
					'section'     => 'callout_section',
					'input_attrs' => [
						'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					],
				]
			)
		);


		// FORMS CONTENT PANEL.
		$wp_customize->add_section( 'why_choose_section', [
			'title'      => __( 'Global Why Choose Column' ),
			'panel'      => 'column_options',
			'capability' => 'edit_theme_options',
		] );

		// TERMS & CONDITIONS.
		$wp_customize->add_setting( 'why_choose', [
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		] );

		$wp_customize->add_control(
			new Skyrocket_TinyMCE_Custom_Control(
				$wp_customize,
				'why_choose',
				[
					'label'       => __( 'Global Why Choose HTML' ),
					'section'     => 'why_choose_section',
					'input_attrs' => [
						'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					],
				]
			)
		);
	}
}
