<?php
/**
 * Theme_Gravity_forms Class
 *
 * Handle theme specific custom Gravity Forms functionality.
 */

/**
 * Theme_Gravity_forms
 */
class Theme_Gravity_Forms {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Using construct function to add any actions and filters associated with the CPT
	 */
	public function __construct() {
		add_filter( 'gform_pre_render', [ $this, 'populate_degree_type' ], 10, 1 );
		add_filter( 'gform_pre_validation', [ $this, 'populate_degree_type' ], 10, 1 );
		add_filter( 'gform_pre_submission_filter', [ $this, 'populate_degree_type' ], 10, 1 );
		add_filter( 'gform_admin_pre_render', [ $this, 'populate_degree_type' ], 10, 1 );

		add_filter( 'gform_pre_render', [ $this, 'populate_metadata_programs' ], 10, 1 );
		add_filter( 'gform_pre_validation', [ $this, 'populate_metadata_programs' ], 10, 1 );
		add_filter( 'gform_pre_submission_filter', [ $this, 'populate_metadata_programs' ], 10, 1 );
		add_filter( 'gform_admin_pre_render', [ $this, 'populate_metadata_programs' ], 10, 1 );

		add_action( 'gform_pre_submission', [ $this, 'make_degree_type_singular' ], 10, 1 );
		add_action( 'gform_pre_submission', [ $this, 'modify_leadcomments' ] );
		add_action( 'gform_pre_submission', [ $this, 'modify_track_camp' ] );
		add_action( 'gform_pre_submission', [ $this, 'modify_advisor_location' ], 10, 2 );

		// Ajax calls.
		add_action( 'wp_ajax_info_degree_select', [ $this, 'degree_select' ] );
		add_action( 'wp_ajax_nopriv_info_degree_select', [ $this, 'degree_select' ] );
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
	 * Dynamically populate the degrees field
	 *
	 * @param array $form The GF form in question.
	 *
	 * @return array
	 */
	public function populate_degree_type( $form ) {
		if ( ! isset( $form['fields'] ) ) {
			return $form;
		}

		foreach ( $form['fields'] as &$field ) {
			// Strap in kids! This explanation is a ride.
			// Bail if it's not a drop down field and more than one choice is defined (GF forces the admin area to have at least one choice...).
			if ( 'select' !== $field->type || ( isset( $field->choices ) && count( $field->choices ) > 1 ) ) {
				continue;
			}

			// Ok, now check if there's ONE choice and if it's completely empty, AND has our very specific class, because if that's not the case. GTFO.
			if ( ! empty( $field->choices[0] ) || false === strpos( $field->cssClass, 'dynamically-populate-degrees' ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			$degree_types = get_terms( [
				'taxonomy' => 'degree-type',
			] );

			$choices = [];

			foreach ( $degree_types as $degree_type ) {
				$choices[] = [
					'text'  => $degree_type->name,
					'value' => $degree_type->slug,
				];
			}

			$choices[] = [
				'text'  => 'Undecided',
				'value' => 'undecided',
			];

			$field->choices = $choices;
		}

		return $form;
	}

	/**
	 * Dynamically populate the programs field on drop downs with the class "populate-program-metadata"
	 *
	 * This should only really be in "area" type form.
	 *
	 * @param array $form The GF form in question.
	 *
	 * @return array
	 */
	public function populate_metadata_programs( $form ) {
		if ( ! isset( $form['fields'] ) ) {
			return $form;
		}

		foreach ( $form['fields'] as &$field ) {
			// Strap in kids! This explanation is a ride.
			// Bail if it's not a drop down field and more than one choice is defined (GF forces the admin area to have at least one choice...).
			if ( is_admin() || 'select' !== $field->type || ( isset( $field->choices ) && count( $field->choices ) > 1 ) ) {
				continue;
			}

			// Ok, now check if there's ONE choice and if it's completely empty, AND has our very specific class, because if that's not the case. GTFO.
			if ( empty( $field->choices[0] ) || false === strpos( $field->cssClass, 'populate-program-metadata' ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				continue;
			}

			$programs = get_post_meta( get_the_ID(), '_nus_template_degrees', true );

			$choices = [];

			// If the page has the program IDs, populate the choices (select field) with the names of the programs
			// for both value and text. For now displayed in alphabetical order.
			if ( ! empty( $programs ) ) {
				$programs_args = [
					'post_type'              => 'program',
					'posts_per_page'         => 100,
					'post__in'               => $programs,
					'order'                  => 'ASC',
					'orderby'                => 'title',
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				];

				$programs_query = new WP_Query( $programs_args );

				if ( $programs_query->have_posts() ) :
					while ( $programs_query->have_posts() ) :
						$programs_query->the_post();

						$choices[] = [
							'text'  => get_the_title(),
							'value' => get_the_title(),
						];
					endwhile;
				endif;

				wp_reset_postdata();
			}

			// "undecided" was at the end on the live site for "area" forms so placing it here.
			// I know I know...it's backwards for "brand" form but gotta do it.
			$choices[] = [
				'text'  => 'Undecided',
				'value' => 'undecided',
			];

			$field->choices = $choices;
		}

		return $form;
	}

	/**
	 * Make degree_type singular when it is saved into our DB or hooks so it is consistent with past setup.
	 *
	 * @param array $form Form currently being processed.
	 *
	 * @return void
	 */
	public function make_degree_type_singular( $form ) {
		$degree_type_id = $this->get_field_id( $form, 'Degree Type', 'label' );

		if ( false !== $degree_type_id ) {
			$degree_type = rgpost( 'input_' . $degree_type_id );

			// Make singular if needed.
			if ( substr( $degree_type, -1 ) === 's' ) {
				$degree_type = substr( $degree_type, 0, -1 );

				$_POST[ 'input_' . $degree_type_id ] = $degree_type;
			}
		}
	}

	/**
	 * Before saving or sending to webhooks,
	 * set "leadcomments" to "paid_search_nonbrand" if the "utm_parameter" was "nonbrand"
	 *
	 * @param array $form Form currently being processed.
	 *
	 * @return void
	 */
	public function modify_leadcomments( $form ) {
		$utm_content_id  = $this->get_field_id( $form, 'utm_content', 'label' );
		$leadcomments_id = $this->get_field_id( $form, 'leadcomments', 'label' );

		if ( false !== $utm_content_id && false !== $leadcomments_id ) {
			$utm_content = rgpost( 'input_' . $utm_content_id );

			if ( 'nonbrand' === trim( $utm_content ) ) {
				$_POST[ 'input_' . $leadcomments_id ] = 'paid_search_nonbrand';
			}
		}
	}

	/**
	 * Before saving or sending to webhooks,
	 * if "track" is empty, set it to the value of "campaign_activity"
	 *
	 * @param array $form Form currently being processed.
	 *
	 * @return void
	 */
	public function modify_track_camp( $form ) {
		$track_id             = $this->get_field_id( $form, 'track', 'label' );
		$campaign_activity_id = $this->get_field_id( $form, 'campaign_activity', 'label' );

		if ( false !== $track_id && false !== $campaign_activity_id ) {
			$track = rgpost( 'input_' . $track_id );

			if ( empty( trim( $track ) ) ) {
				$_POST[ 'input_' . $track_id ] = rgpost( 'input_' . $campaign_activity_id );
			}
		}
	}

	/**
	 * Before saving or sending to webhooks,
	 * if "military" field is not empty, set the field with "Advisory Location" label to "military"
	 *
	 * @param array $form Form currently being processed.
	 *
	 * @return void
	 */
	public function modify_advisor_location( $form ) {
		$advisor_location_id = $this->get_field_id( $form, 'Advisor Location', 'label' );
		$military_id         = $this->get_field_id( $form, 'military', 'type' );

		if ( false !== $advisor_location_id && false !== $military_id ) {
			$military = rgpost( 'input_' . $military_id . '_1' );
			if ( ! empty( $military ) ) {
				$_POST[ 'input_' . $advisor_location_id ] = 'military';
			}
		}
	}

	/**
	 * Filter programs by taxonomy
	 *
	 * Creates a list of programs filtered by taxonomy, output as options
	 */
	public function degree_select() {
		// Make sure the value is in the request.
		if ( empty( $_POST['degreeType'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			wp_die();
		}

		// Get our ajax passed data.
		$degree_type     = sanitize_text_field( wp_unslash( $_POST['degreeType'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$modify_programs = ! empty( $_POST['modifyPrograms'] ) ? true : false; // phpcs:ignore WordPress.Security.NonceVerification.Missing

		if ( 'undecided' === $degree_type ) {
			echo '<option value="N/A">N/A</option>';
		} else {
			// Get the ID of our term from it's name.
			$term = get_term_by( 'slug', $degree_type, 'degree-type' );

			// Setup array of current program types and their new names.
			$new_program_names = [
				'Associate of Arts'    => 'AA',
				'Associate of Science' => 'AS',
				'Bachelor of Arts'     => 'BA',
				'Bachelor of Science'  => 'BS',
				'Master of Arts'       => 'MA',
				'Master of Education'  => 'ME',
				'Master of Fine Arts'  => 'MFA',
				'Master of Science'    => 'MS',
			];

			$programs = get_transient( 'form_programs_' . $term->slug );

			if ( false === $programs ) {
				// Setup our query args.
				$args     = [
					'order'                  => 'ASC',
					'orderby'                => 'title',
					'post_type'              => 'program',
					'post_status'            => 'publish',
					'posts_per_page'         => 100,
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
					'tax_query'              => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						[
							'taxonomy' => 'degree-type',
							'field'    => 'slug',
							'terms'    => $term->slug,
						],
					],
				];
				$programs = new WP_Query( $args );

				// Save our transient.
				set_transient( 'form_programs_' . $term->slug, $programs, HOUR_IN_SECONDS );
			}

			if ( $programs->have_posts() ) {
				while ( $programs->have_posts() ) {
					$programs->the_post();
					// Get our custom meta.
					$teachout = get_post_meta( get_the_ID(), 'teachout', true );

					// If program is not in teachout actually display it.
					if ( 'yes' !== $teachout ) {
						// Replace any dashes with spaces.
						$title = str_replace( '&#8211; ', ' ', get_the_title() );

						// Set our var to null.
						$shortened_title = null;

						// Loop through the program name array to shorten the display title names.
						foreach ( $new_program_names as $full_name => $abbreviation ) {
							if ( stripos( $title, $full_name ) !== false ) {
								$shortened_title = str_replace( $full_name, $abbreviation, $title );
								break;
							}
						}

						// Determine which title to display.
						$display_title = ( null !== $shortened_title && true === $modify_programs ) ? $shortened_title : $title;

						// Output all programs as options.
						echo '<option value="' . esc_attr( $title ) . '">' . esc_html( $display_title ) . '</option>' . "\n";
					}
				}
			}
			wp_reset_postdata();
		}
		// RIP.
		wp_die();
	}

	/**
	 * Gets the field ID from the type
	 *
	 * @param array  $form  GF data of form.
	 * @param string $value Value we are trying to find inside the form.
	 * @param string $key   The type we are trying to find.
	 */
	private function get_field_id( $form, $value, $key = 'type' ) {
		foreach ( $form['fields'] as $field ) {
			if ( strtolower( $field->$key ) === strtolower( $value ) ) {
				return $field->id;
			}
		}
		return false;
	}
}
