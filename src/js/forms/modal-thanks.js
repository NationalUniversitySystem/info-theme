jQuery( document ).ready( function( $ ) {
	$( document ).on( 'gform_confirmation_loaded', function() {
		$( '#thanks-modal' ).modal( 'show' );

		$( '#thanks-modal' ).click( function() {
			window.location.reload();
		} );
	} );
} );
