<?php
/**
 * Form_Dynamic_Population Class
 *
 * Handle Gravity Forms field dynamic population functionality.
 */

/**
 * Form_Dynamic_Population
 */
class Form_Dynamic_Population {
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
		add_filter( 'gform_field_value_populate-hidden-degree-type', [ $this, 'populate_hidden_degree_type' ] );
		add_filter( 'gform_field_value_populate-hidden-program', [ $this, 'populate_hidden_program' ] );
		add_filter( 'gform_field_value_campaign_activity', [ $this, 'populate_campaign_activity' ] );
		add_filter( 'gform_field_value_arrivaluri', [ $this, 'populate_arrivaluri' ] );
		add_filter( 'gform_field_value_location', [ $this, 'populate_location' ] );
		add_filter( 'gform_field_value_lead_transactionID', [ $this, 'populate_lead_transaction_id' ] );
		add_filter( 'gform_field_value', [ $this, 'populate_eloqua_dynamic_fields' ], 10, 3 );
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
	 * Dynamically populate the hidden degree-type field field.
	 * Hidden field requires the parameter name to be "populate-hidden-degree-type"
	 *
	 * @param string $value Value passed into the hook.
	 * @return string
	 */
	public function populate_hidden_degree_type( $value ) {
		$degree_type_ids = get_post_meta( get_the_ID(), '_nus_template_degree_type', true );

		if ( ! empty( $degree_type_ids ) ) {
			$degree_type = get_term( $degree_type_ids[0], 'degree-type' );

			if ( ! empty( $degree_type ) ) {
				$value = $degree_type->slug;

				// Make singular if needed.
				if ( substr( $value, -1 ) === 's' ) {
					$value = substr( $value, 0, -1 );
				}
			}
		}

		return $value;
	}

	/**
	 * Dynamically populate the hidden program field field.
	 * Hidden field requires the parameter name to be "populate-hidden-program"
	 *
	 * @param string $value Value passed into the hook.
	 * @return string
	 */
	public function populate_hidden_program( $value ) {
		$degrees_ids = get_post_meta( get_the_ID(), '_nus_template_degrees', true );

		if ( ! empty( $degrees_ids ) ) {
			$degree_id = is_array( $degrees_ids ) ? $degrees_ids[0] : $degrees_ids;
			$value     = get_the_title( $degree_id );
		}

		return $value;
	}

	/**
	 * Dynamically populate the campaign activity with the metadata value of the page or the parent page.
	 *
	 * @param string $value Value passed into the hook.
	 * @return string
	 */
	public function populate_campaign_activity( $value ) {
		if ( empty( $value ) ) {
			$value = get_post_meta( get_the_ID(), '_nus_template_form_campaign_activity', true );

			if ( empty( $value ) ) {
				$value = get_campaign_activity();
			}
		}

		return $value;
	}

	/**
	 * Dynamically populate the arrivaluri for tracking and reference.
	 *
	 * @param string $value Value passed into the hook.
	 *
	 * @return string
	 */
	public function populate_arrivaluri( $value ) {
		if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
			$value = home_url() . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
		}

		return $value;
	}

	/**
	 * Dynamically populate the location field with the permalink of the page.
	 *
	 * @param string $value Value passed into the hook.
	 *
	 * @return string
	 */
	public function populate_location( $value ) {
		if ( empty( $value ) ) {
			$value = get_the_permalink();
		}

		return $value;
	}

	/**
	 * Dynamically populate the populate_lead_transactionID.
	 *
	 * @param string $value Value passed into the hook.
	 *
	 * @return string
	 */
	public function populate_lead_transaction_id( $value ) {
		if ( empty( $value ) && ! empty( $_GET['elqctid'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$ref_id = sanitize_text_field( wp_unslash( $_GET['elqctid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$ref_id = preg_replace( '/[A-Za-z]/', '0', $ref_id );
			$ref_id = intval( $ref_id );

			$this->fetch_eloqua_info( $ref_id, 'complete' );

			if ( ! empty( $this->response_data ) && ! empty( $this->response_data->fieldValues ) ) {
				foreach ( $this->response_data->fieldValues as $field_value ) {
					if ( is_object( $field_value ) ) {
						if ( '100287' === $field_value->id && isset( $field_value->value ) ) {
							$value = $field_value->value;
						}
					}
				}
			}
		}

		return $value;
	}
	/**
	 * Dynamically populate the dynamic fields via Eloqua request.
	 *
	 * $ref_id = '1636896'; // Good for testing
	 *
	 * @param string $value Value passed into the hook.
	 * @param object $field Gravity forms object field being processed.
	 * @param string $name  Input name of field, corresponding to the name set in admin.
	 *
	 * @return string
	 */
	public function populate_eloqua_dynamic_fields( $value, $field, $name ) {
		// Array key is the form dynamic parameter name in GF and the value is the returned eloqua key.
		$dynamic_names_to_populate = [
			'first_name'     => 'firstName',
			'last_name'      => 'lastName',
			'email_address'  => 'emailAddress',
			'phone_number'   => [
				'mobilePhone',
				'businessPhone',
			],
			'street_address' => 'address1',
			'city'           => 'city',
			'postal_code'    => 'postalCode',
			'country'        => 'country',
		];

		if ( array_key_exists( $name, $dynamic_names_to_populate ) && ! empty( $_GET['elqctid'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$ref_id = sanitize_text_field( wp_unslash( $_GET['elqctid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$ref_id = preg_replace( '/[A-Za-z]/', '0', $ref_id );
			$ref_id = intval( $ref_id );

			$this->fetch_eloqua_info( $ref_id );

			if ( ! empty( $this->response_data ) ) {
				$response_data_array = (array) $this->response_data;
				$gf_key              = $dynamic_names_to_populate[ $name ];

				if ( ! is_array( $gf_key ) ) {
					$eloqua_key = $gf_key;
				} else {
					$eloqua_key = ! empty( $response_data_array[ $gf_key[0] ] ) ? $gf_key[0] : $gf_key[1];
				}

				$value = ! empty( $response_data_array[ $eloqua_key ] ) ? $response_data_array[ $eloqua_key ] : '';
			}
		}

		return $value;
	}

	/**
	 * Fetch user data via the Eloqua API and set it as the object's data.
	 *
	 * @param int    $ref_id User Eloqua reference ID.
	 * @param string $depth  Depth of response request.
	 *
	 * @return void
	 */
	private function fetch_eloqua_info( $ref_id, $depth = 'partial' ) {
		if ( empty( $this->response_data ) || 'partial' !== $depth ) {
			$eloqua_url = 'https://secure.p03.eloqua.com/api/REST/1.0/data/contact/' . $ref_id . '?depth=' . $depth;

			$eloqua_args = [
				'headers' => [
					'Accept'        => 'application/json',
					'Content-Type'  => 'application/json',
					'Cache-Control' => 'no-cache',
					'Authorization' => 'Basic TmF0aW9uYWxVbml2ZXJzaXR5XE5VV2ViRGV2LkJ1bGtBUEk6eWU4M3J1dFJVc2FjZVc=',
				],
			];

			$response = wp_remote_retrieve_body( wp_remote_request( $eloqua_url, $eloqua_args ) );

			$this->response_data = json_decode( $response );
		}
	}
}
