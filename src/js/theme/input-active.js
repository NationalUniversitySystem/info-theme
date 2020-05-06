( function( d ) {
	// Set it and forget it.
	const body = document.querySelector( 'body' );

	// Add the active class to text inputs on focus.
	body.addEventListener( 'focus', event => {
		if ( event.target.classList.contains( 'input--text' ) ) {
			event.target.closest( '.gfield' ).classList.add( 'input--active' );
		}
	}, true );

	// Remove the active class from text inputs on blur if no value entered.
	body.addEventListener( 'blur', event => {
		if ( event.target.classList.contains( 'input--text' ) && '' === event.target.value ) {
			event.target.closest( '.gfield' ).classList.remove( 'input--active' );
		}
	}, true );

	// Add the active class to selects once option has been chosen.
	body.addEventListener( 'change', event => {
		if ( event.target.classList.contains( 'input--select' ) && '' !== event.target.value ) {
			event.target.closest( '.gfield' ).classList.add( 'input--active' );
		}
	}, true );

	// When the form is rendered, check if any fields have a value, if so give them the active class.
	// Using jQuery because it's the only way to access the 'gform_post_render' event.
	d.ongform_post_render = function( event, formId ) { // eslint-disable-line camelcase
		const inputs = document.querySelectorAll( '#gform_wrapper_' + formId + ' .input--text' );
		inputs.forEach( function( input ) {
			if ( input.value !== '' ) {
				this.closest( '.gfield' ).classList.add( 'input--active' );
			}
		} );
	};
} )( document );
