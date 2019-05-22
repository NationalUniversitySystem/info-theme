jQuery( document ).ready( function( $ ) {

	$( document ).on( 'gform_confirmation_loaded', function( event, formId ) {

		function thanksModal() {
			$( '#thanks-modal' ).modal( 'show' );

			$( '#thanks-modal' ).click( function() {
				window.location.reload();
			} );
		}

		// If the formID is '4' (which is the current Outreach Form ID).
		// Hardcoding ID not the best method, will look into updating later.
		formId === 4 ? thanksModal() : '';
	} );
} );
