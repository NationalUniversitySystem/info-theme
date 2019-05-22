( function( document, $ ) {
	function toggleSubmitButton( formId ) {
		const checkbox = document.querySelector( '#gform_wrapper_' + formId + ' .ginput_container_consent input' );

		if ( checkbox ) {
			const submitButton = document.querySelector( '.gform_footer button' );

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
	$( document ).on( 'gform_post_render', function( event, formId ) {
		toggleSubmitButton( formId );
	} );
} )( document, jQuery );
