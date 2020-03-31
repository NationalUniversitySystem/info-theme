( function( d, $ ) {
	function toggleSubmitButton( formId ) {
		const form = d.querySelector( '#gform_wrapper_' + formId );
		const checkbox = form.querySelector( '.ginput_container_consent input' );
		let submitButton = form.querySelector( ' .gform_footer button' );

		submitButton = submitButton || form.querySelector( '.gform_footer input[type="submit"]' );

		if ( checkbox && submitButton ) {
			submitButton.setAttribute( 'disabled', 'disabled' );
			checkbox.addEventListener( 'change', function() {
				const isChecked = checkbox.checked;

				if ( isChecked ) {
					submitButton.removeAttribute( 'disabled' );
				} else {
					submitButton.setAttribute( 'disabled', 'disabled' );
				}
			}, false );
		}
	}

	// Have to use jQuery since gravity forms is binding to this hook via jQuery.
	// If anyone has any suggestions to hook into this event, by all means go for it.
	$( d ).on( 'gform_post_render', function( event, formId ) {
		toggleSubmitButton( formId );
	} );
} )( document, jQuery );
