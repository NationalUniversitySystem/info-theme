<?php
/**
 * Set up theme Global Forms management in customizer
 *
 * @package national-university
 */

/**
 * Nu_Customizer_Global_Forms class
 */
class Nu_Customizer_Global_Forms {
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
		add_action( 'customize_register', [ $this, 'add_global_forms_section' ] );
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
	 * Add the Global Forms panel
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_global_forms_section( $wp_customize = null ) {
		// CUSTOM FORMS PANEL.
		$wp_customize->add_panel( 'form_options', [
			'priority'   => 10,
			'title'      => __( 'Global Forms', 'national-university' ),
			'capability' => 'edit_theme_options',
		] );

		// Bail if the class for forms does not exist.
		// But Leaving the panel and the terms section so it helps avoid confusion and track down any issue that may arise,
		// like the class not existing.
		$this->add_terms_section( $wp_customize );

		// Add a new section for our default intro text.
		$this->add_form_intro_section( $wp_customize );

		if ( ! class_exists( 'GFAPI' ) ) {
			return;
		}

		// Call the method to save the forms array as a class variable.
		$this->fetch_gravity_forms();

		// Add each section separately, for organizational purposes.
		$this->add_rfi_section( $wp_customize );
	}

	/**
	 * Add the Terms & Condition section, setting, and control
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_terms_section( $wp_customize = null ) {

		// FORMS CONTENT PANEL.
		$wp_customize->add_section( 'terms_conditions_section', [
			'title'      => __( 'Terms & Conditions' ),
			'panel'      => 'form_options',
			'capability' => 'edit_theme_options',
		] );

		// TERMS & CONDITIONS.
		$wp_customize->add_setting( 'terms_conditions', [
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		] );

		$wp_customize->add_control(
			new Skyrocket_TinyMCE_Custom_Control(
				$wp_customize,
				'terms_conditions',
				[
					'label'       => __( 'Global Terms & Conditions' ),
					'section'     => 'terms_conditions_section',
					'input_attrs' => [
						'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					],
				]
			)
		);
	}

	/**
	 * Add the Terms & Condition section, setting, and control
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_form_intro_section( $wp_customize = null ) {

		// FORMS CONTENT PANEL.
		$wp_customize->add_section( 'form_intro_section', [
			'title'      => __( 'Default Form Intro Text' ),
			'panel'      => 'form_options',
			'capability' => 'edit_theme_options',
		] );

		// TERMS & CONDITIONS.
		$wp_customize->add_setting( 'form_intro', [
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		] );

		$wp_customize->add_control(
			new Skyrocket_TinyMCE_Custom_Control(
				$wp_customize,
				'form_intro',
				[
					'label'       => __( 'Intro Text' ),
					'section'     => 'form_intro_section',
					'input_attrs' => [
						'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					],
				]
			)
		);
	}


	/**
	 * Add the Global RFI form section, setting, and control
	 *
	 * @param object $wp_customize WP_Customize_Manager object.
	 *
	 * @return void
	 */
	public function add_rfi_section( $wp_customize = null ) {
		// FORMS CONTENT PANEL.
		$wp_customize->add_section( 'rfi_sidebar', [
			'title'      => __( 'Global RFI' ),
			'panel'      => 'form_options',
			'capability' => 'edit_theme_options',
		] );

		// FORM ID.
		$wp_customize->add_setting( 'rfi_sidebar_form_id', [
			'default'   => '',
			'transport' => 'postMessage',
		] );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'rfi_sidebar_form_id',
				[
					'type'     => 'select',
					'label'    => __( 'RFI Sidebar Form', 'national-university' ),
					'section'  => 'rfi_sidebar',
					'settings' => 'rfi_sidebar_form_id',
					'choices'  => $this->forms,
				]
			)
		);
	}

	/**
	 * Gets all the gravity forms and set them to our class variable to use by other class methods
	 *
	 * @return void
	 */
	public function fetch_gravity_forms() {
		// Create an array with a default null value
		// (so if no form is needed, one is not saved by default)
		// to add our form data into as <option>.
		$gravity_forms = [ '' => '-- Select A Form --' ];

		// Get all of our info on Gravity Forms in an array so all sections can use it.
		$forms = GFAPI::get_forms();

		// Loop through all the Gravity Forms data.
		foreach ( $forms as $form ) {

			// Add our Gravity Forms as <options> into the select,
			// with the form ID as the value, and the form name as the option label.
			$gravity_forms[ $form['id'] ] = $form['title'];
		}

		// Sort our forms array alphabetically for easy organization within the select.
		asort( $gravity_forms );

		$this->forms = $gravity_forms;
	}

}
