<?php
/**
 * Applite thank you page which will generate the "Applite" form, by title
 *
 * - Use '1636896' as $ref_id for testing in the API response below.
 */

if ( ! empty( $_GET['elqctid'] ) ) {
	$ref_id = sanitize_text_field( $_GET['elqctid'] );
	$ref_id = preg_replace( '/[A-Za-z]/', '0', $ref_id );
	$ref_id = intval( $ref_id );

	$eloqua_url = 'https://secure.p03.eloqua.com/api/REST/1.0/data/contact/' . $ref_id . '?depth=partial';

	$eloqua_args = array(
		'headers' => array(
			'Accept'        => 'application/json',
			'Content-Type'  => 'application/json',
			'Cache-Control' => 'no-cache',
			'Authorization' => 'Basic TmF0aW9uYWxVbml2ZXJzaXR5XE5VV2ViRGV2LkJ1bGtBUEk6eWU4M3J1dFJVc2FjZVc=',
		),
	);

	$response = wp_remote_retrieve_body( wp_remote_request( $eloqua_url, $eloqua_args ) );

	$response_data = json_decode( $response );

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.NotSnakeCaseMemberVar
	$first_name     = $response_data->firstName;
	$last_name      = $response_data->lastName;
	$email_address  = $response_data->emailAddress;
	$phone_number   = ( '' !== trim( $response_data->mobilePhone ) ) ? $response_data->mobilePhone : $response_data->businessPhone;
	$street_address = $response_data->address1;
	$city           = $response_data->city;
	$postal_code    = ! empty( $response_data->postalCode ) ? $response_data->postalCode : '';
	$country        = $response_data->country;
	// phpcs:enable
} else {
	$first_name     = isset( $_REQUEST['first_name'] ) ? $_REQUEST['first_name'] : '';
	$last_name      = isset( $_REQUEST['last_name'] ) ? $_REQUEST['last_name'] : '';
	$email_address  = isset( $_REQUEST['email_address'] ) ? $_REQUEST['email_address'] : '';
	$phone_number   = isset( $_REQUEST['phone'] ) ? $_REQUEST['phone'] : '';
	$street_address = '';
	$city           = '';
	$postal_code    = isset( $_REQUEST['zip'] ) ? $_REQUEST['zip'] : '';
	$country        = '';
}

$military = isset( $_REQUEST['military'] ) ? $_REQUEST['military'] : '';

// Build the array with values of fields that can be dynamically populated.
$form_values = [
	'first_name'     => $first_name,
	'last_name'      => $last_name,
	'email_address'  => $email_address,
	'phone_number'   => $phone_number,
	'street_address' => $street_address,
	'postal_code'    => $postal_code,
	'country'        => $country,
	'military'       => $military,
];
?>
<article class="page type-page hentry">
	<div class="entry-title">
		<p class="intro-text">Thank you, <?php echo esc_html( $first_name . ' ' . $last_name ); ?>! An admissions advisor will be in touch soon.</p>
		<h1>Want to Expedite the Admissions Process?</h1>
	</div>
	<div class="entry-content">
		<p>Start the application below, and our admissions team will make your application a priority and help you get enrolled faster.</p>
		<p class="intro-text">To get started, fill out the form below.</p>

		<div class="info-section__form">
			<div class="form__inner">
				<?php gravity_form( 'Applite', false, false, false, $form_values, true ); ?>
			</div>
		</div>
	</div>
</article>
