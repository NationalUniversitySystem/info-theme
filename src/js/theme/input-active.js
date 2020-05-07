// Set it and forget it.
const body = document.querySelector( 'body' );

// Add the active class to text inputs on focus.
body.addEventListener( 'focus', ( event ) => {
	if ( event.target.classList.contains( 'input--text' ) ) {
		event.target.closest( '.gfield' ).classList.add( 'input--active' );
	}
}, true );

// Remove the active class from text inputs on blur if no value entered.
body.addEventListener( 'blur', ( event ) => {
	if ( event.target.classList.contains( 'input--text' ) && '' === event.target.value ) {
		event.target.closest( '.gfield' ).classList.remove( 'input--active' );
	}
}, true );

// Add the active class to selects once option has been chosen.
body.addEventListener( 'change', ( event ) => {
	if ( event.target.classList.contains( 'input--select' ) && '' !== event.target.value ) {
		event.target.closest( '.gfield' ).classList.add( 'input--active' );
	}
}, true );

// When the form is rendered, check if any fields have a value, if so give them the active class.
// Using jQuery because it's the only way to access the 'gform_post_render' event.
jQuery( document ).on( 'gform_post_render', function() {
	jQuery( '.input--text' ).each( function() {
		if ( jQuery( this ).val() !== '' ) {
			jQuery( this ).closest( '.gfield' ).addClass( 'input--active' );
		}
	} );
} );
