<?php
/**
 * Set up all our theme related SOAR functionality
 *
 * @package nusa
 */

/**
 * Soar_Setup class
 */
class Soar_Setup {
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
		add_filter( 'gform_form_settings', array( $this, 'add_soar_form_setting' ), 10, 2 );
		add_filter( 'gform_pre_form_settings_save', array( $this, 'save_soar_form_setting' ) );

		add_action( 'gform_after_submission', array( $this, 'post_to_soar' ), 10, 2 );
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
	 * Add our custom setting markup
	 *
	 * @param array $settings Holds all the form settings and markup.
	 * @param array $form     Data about the current form.
	 *
	 * @return array
	 */
	public function add_soar_form_setting( $settings, $form ) {
		$enable_soar = '';
		if ( rgar( $form, 'enable_soar' ) ) {
			$enable_soar = ' checked="checked"';
		}

		$settings['Form Options']['enable_soar'] = '<tr>
			<th>Send form data to SOAR datapoint</th>
			<td>
				<input type="checkbox" name="enable_soar" id="enable_soar" value="1"' . $enable_soar . '>
				<label for="enable_soar">Enable SOAR usage</label>
			</td>
		</tr>';

		return $settings;
	}

	/**
	 * Save our custom setting
	 *
	 * @param array $form Data of the form being saved.
	 *
	 * @return array
	 */
	public function save_soar_form_setting( $form ) {
		$form['enable_soar'] = rgpost( 'enable_soar' );

		return $form;
	}

	/**
	 * Handle the attempt to send this form to SOAR
	 *
	 * @param array $entry Array holding all of this entry's data.
	 * @param array $form  The corresponding parent form for this entry.
	 *
	 * @return void
	 */
	public function post_to_soar( $entry, $form ) {
		// Bail if this form does not have SOAR enabled.
		$soar_form_status = rgar( $form, 'enable_soar' );

		if ( empty( $soar_form_status ) ) {
			return;
		}

		// Prepare SOAR details.
		$this->process_soar_entry( $entry, $form );
	}

	/**
	 * Process the POST request to SOAR
	 *
	 * @param array $entry Array holding all of this entry's data.
	 * @param array $form  The corresponding parent form for this entry.
	 *
	 * @return void
	 */
	private function process_soar_entry( $entry, $form ) {
		$add_link_array = [];

		$utm_source_id = $this->get_field_id( $form, 'utm_source', 'label' );
		if ( false !== $utm_source_id && isset( $entry[ $utm_source_id ] ) && '' !== trim( $entry[ $utm_source_id ] ) ) {
			$add_link_array[] = 'utm_source=' . $entry[ $utm_source_id ];
		}

		$utm_medium_id = $this->get_field_id( $form, 'utm_medium', 'label' );
		if ( false !== $utm_medium_id && isset( $entry[ $utm_medium_id ] ) && '' !== trim( $entry[ $utm_medium_id ] ) ) {
			$add_link_array[] = 'utm_medium=' . $entry[ $utm_medium_id ];
		}

		$utm_campaign_id = $this->get_field_id( $form, 'utm_campaign', 'label' );
		if ( false !== $utm_campaign_id && isset( $entry[ $utm_campaign_id ] ) && '' !== trim( $entry[ $utm_campaign_id ] ) ) {
			$add_link_array[] = 'utm_campaign=' . $entry[ $utm_campaign_id ];
		}

		$utm_term_id = $this->get_field_id( $form, 'utm_term', 'label' );
		if ( false !== $utm_term_id && isset( $entry[ $utm_term_id ] ) && '' !== trim( $entry[ $utm_term_id ] ) ) {
			$add_link_array[] = 'utm_term=' . $entry[ $utm_term_id ];
		}

		$utm_content_id = $this->get_field_id( $form, 'utm_content', 'label' );
		if ( false !== $utm_content_id && isset( $entry[ $utm_content_id ] ) && '' !== trim( $entry[ $utm_content_id ] ) ) {
			$add_link_array[] = 'utm_content=' . $entry[ $utm_content_id ];
		}

		$track_id = $this->get_field_id( $form, 'track', 'label' );
		if ( false !== $track_id && isset( $entry[ $track_id ] ) && '' !== trim( $entry[ $track_id ] ) ) {
			$add_link_array[] = 'track=' . $entry[ $track_id ];
		}

		$gclid_id = $this->get_field_id( $form, 'GA_UserID', 'label' );
		if ( false !== $gclid_id && isset( $entry[ $gclid_id ] ) && '' !== trim( $entry[ $gclid_id ] ) ) {
			$add_link_array[] = 'gclid=' . $entry[ $gclid_id ];
		}

		$add_link = implode( '&', $add_link_array );

		$first_name_id = $this->get_field_id( $form, 'first_name', 'inputName' );
		$first_name    = $entry[ $first_name_id ];
		$last_name_id  = $this->get_field_id( $form, 'last_name', 'inputName' );
		$last_name     = $entry[ $last_name_id ];
		$email_id      = $this->get_field_id( $form, 'email_address', 'inputName' );
		$email         = $entry[ $email_id ];
		$phone_id      = $this->get_field_id( $form, 'phone_number', 'inputName' );
		$phone         = $entry[ $phone_id ];
		$address_id    = $this->get_field_id( $form, 'street_address', 'inputName' );
		$address       = $entry[ $address_id ];
		$city_id       = $this->get_field_id( $form, 'city', 'inputName' );
		$city          = $entry[ $city_id ];
		$state_id      = $this->get_field_id( $form, 'state', 'label' );
		$state         = $entry[ $state_id ];
		$zip_code_id   = $this->get_field_id( $form, 'postal_cade', 'inputName' );
		$zip_code      = $entry[ $zip_code_id ];
		$country_id    = $this->get_field_id( $form, 'country', 'inputName' );
		$country       = $entry[ $country_id ];

		$military_id   = $this->get_field_id( $form, 'military', 'label' );
		$military      = $entry[ $military_id ];
		$degreetype_id = $this->get_field_id( $form, 'Degree Type', 'label' );
		$degreetype    = $entry[ $degreetype_id ];

		$program_id    = $this->get_field_id( $form, 'Program', 'label' );
		$program       = $entry[ $program_id ];
		$class_type_id = $this->get_field_id( $form, 'class_type', 'inputName' );
		$class_type    = $entry[ $class_type_id ];
		$starting_id   = $this->get_field_id( $form, 'starting', 'label' );
		$starting      = $entry[ $starting_id ];
		$experience_id = $this->get_field_id( $form, 'experience', 'label' );
		$experience    = $entry[ $experience_id ];

		$military = ! empty( $military ) ? 'Y' : 'N';

		// Build XML data
		// To display the XML response in a formatted output, use $dom->formatOutput = true;
		// Note: For Keyvalues do not add line breaks around values.
		$dom = new DOMDocument( '1.0' );

		$request = $dom->appendChild( $dom->createElement( 'NU_OA2_RFI_REQUEST' ) );
		$request->setAttribute( 'LOGLEVEL', 10 );
		$request->setAttribute( 'xmlns', 'http://xmlns.oracle.com/Enterprise/Tools/schemas/NU_OA2_RFI_REQUEST.V1' );

		$app_data = $request->appendChild( $dom->createElement( 'APPLICATION_DATA' ) );

		$nu_person = $app_data->appendChild( $dom->createElement( 'NU_OA2_PERSON' ) );
		$nu_person->setAttribute( 'class', 'R' );
		$nu_person->setAttribute( 'xmlns', 'http://xmlns.oracle.com/Enterprise/Tools/schemas/APPLICATION_DATA.V1' );
		$nu_person->appendChild( $dom->createElement( 'EMAILID', esc_html( $email ) ) );
		$nu_person->appendChild( $dom->createElement( 'FIRST_NAME', esc_html( $first_name ) ) );
		$nu_person->appendChild( $dom->createElement( 'MIDDLE_NAME' ) );
		$nu_person->appendChild( $dom->createElement( 'LAST_NAME', esc_html( $last_name ) ) );
		$nu_person->appendChild( $dom->createElement( 'SEX' ) );
		$nu_person->appendChild( $dom->createElement( 'PHONE', esc_html( $phone ) ) );
		$nu_person->appendChild( $dom->createElement( 'PHONE_TYPE' ) );
		$nu_person->appendChild( $dom->createElement( 'COUNTRY_CODE' ) );
		$nu_person->appendChild( $dom->createElement( 'ADDRESS1', esc_html( $address ) ) );
		$nu_person->appendChild( $dom->createElement( 'ADDRESS2' ) );
		$nu_person->appendChild( $dom->createElement( 'CITY', esc_html( $city ) ) );
		$nu_person->appendChild( $dom->createElement( 'STATE', esc_html( $state ) ) );
		$nu_person->appendChild( $dom->createElement( 'POSTAL', esc_html( $zip_code ) ) );
		$nu_person->appendChild( $dom->createElement( 'COUNTRY', esc_html( $country ) ) );
		$nu_person->appendChild( $dom->createElement( 'NU_OA2_MIL_YN', esc_html( $military ) ) );

		$keyvalue_add_link = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_add_link->setAttribute( 'class', 'R' );
		$keyvalue_add_link->appendChild( $dom->createElement( 'KEY', 'ATTRIBUTION' ) );
		$keyvalue_add_link->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . htmlspecialchars( trim( $add_link ) ) . ']]>' ) );

		$keyvalue_degree_type = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_degree_type->setAttribute( 'class', 'R' );
		$keyvalue_degree_type->appendChild( $dom->createElement( 'KEY', 'Degree Type' ) );
		$keyvalue_degree_type->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . esc_html( $degreetype ) . ']]>' ) );

		$keyvalue_program = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_program->setAttribute( 'class', 'R' );
		$keyvalue_program->appendChild( $dom->createElement( 'KEY', 'Program' ) );
		$keyvalue_program->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . esc_html( $program ) . ']]>' ) );

		$keyvalue_class_type = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_class_type->setAttribute( 'class', 'R' );
		$keyvalue_class_type->appendChild( $dom->createElement( 'KEY', 'Class Type' ) );
		$keyvalue_class_type->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . esc_html( $class_type ) . ']]>' ) );

		$keyvalue_timeframe = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_timeframe->setAttribute( 'class', 'R' );
		$keyvalue_timeframe->appendChild( $dom->createElement( 'KEY', 'Starting Timeframe' ) );
		$keyvalue_timeframe->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . esc_html( $starting ) . ']]>' ) );

		$keyvalue_experience = $nu_person->appendChild( $dom->createElement( 'KEYVALUE' ) );
		$keyvalue_experience->setAttribute( 'class', 'R' );
		$keyvalue_experience->appendChild( $dom->createElement( 'KEY', 'Experience' ) );
		$keyvalue_experience->appendChild( $dom->createElement( 'VALUE', '<![CDATA[' . esc_html( $experience ) . ']]>' ) );

		$soap_body = $dom->saveXML();

		// URL for testing and production.
		if ( ( defined( 'VIP_GO_ENV' ) && in_array( VIP_GO_ENV, array( 'production' ), true ) ) ) {
			$soar_url = 'https://nusmsg.soar.cci.nu.edu/PSIGW/RESTListeningConnector/PSFT_NUSS9PRD/NU_OA2_RFI_CREATE.v1/application/NATLU/RFI_START';
		} else {
			$soar_url = 'https://nusdevmsg.soar.cci.nu.edu/PSIGW/RESTListeningConnector/PSFT_NUSS9TST/NU_OA2_RFI_CREATE.v1/application/NATLU/RFI_START';
		}

		$response = wp_remote_post( $soar_url, array(
			'body'    => $soap_body,
			'headers' => array(
				'Content-Type'  => 'application/xml',
				'Authorization' => 'Basic TlVfTUFSS0VUSU5HX1dPUkRQUkVTUzpxWEFra2NNV3NEZFpzQmJhYmVyQ1JXdjZ1QVhGRVJvcW0z',
			),
		) );

		// SOAR error flag.
		$error_hint = '';

		if ( ! is_wp_error( $response ) ) {
			if ( 200 === $response['response']['code'] ) {
				$body = wp_remote_retrieve_body( $response );

				// Remove notes since it's breaking the XML.
				$body           = preg_replace( '/<NOTES>(?s).*<\/NOTES>/', '', $body );
				$result_xml     = simplexml_load_string( $body );
				$xml_attributes = $result_xml->attributes();

				if ( isset( $xml_attributes['NU_OA2_APP_GUID'] ) ) {
					$soar_guid = (string) $xml_attributes['NU_OA2_APP_GUID'];

					// Save the SOAR ID as metadata for the entry.
					gform_update_meta( $entry['id'], 'soarUUID', $soar_guid );
				} else {
					$error_hint = 'No soarUUID returned';
				}
			} else {
				$error_hint = 'Failed response from SOAR (http code = ' . $response['response']['code'] . ')';
			}
		} else {
			$error_hint = 'Failed response from SOAR (CURL error)';
		}

		// Send email if any error.
		if ( '' !== $error_hint ) {
			// Set our SOAR ID to blank so these entries always have a SOAR ID.
			gform_update_meta( $entry['id'], 'soarUUID', '' );

			$admin_emails = array();
			$site_admins  = get_users( 'role=Administrator' );

			foreach ( $site_admins as $admin ) {
				$admin_emails[] = $admin->user_email;
			}

			$headers = array( 'Content-Type: text/html; charset=UTF-8' );

			$email_subject = 'National University Info Admin - ' . $form['title'] . ' Error';

			// Building out the whole body.
			$body = '<p>There was an ' . $form['title'] . " submission which didn't make it to the SOAR system.</p>\n
				<p>Please check site and run attempt in admin to push data again.</p>\n
				<p><strong>Error hint: </strong>${error_hint}</p>\n
				<p>Entry ID: " . $entry['id'] . "</p>\n
				<p><strong>This is an auto-generated message.</strong></p>";

			wp_mail( $admin_emails, $email_subject, $body, $headers );
		}
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
