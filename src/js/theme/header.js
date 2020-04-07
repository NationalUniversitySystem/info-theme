/**
 * Get the height of the header and apply it's height as padding to the body.
 * Once that is done, apply the fixed class to the header
 * since we need to account for the height as padding to push the rest of the content down so it's not hidden.
 * This is done via JS so there's no flash of content.
 */
( function( w, d ) {
	if ( d.querySelector( 'header' ) !== null ) {
		const header = d.querySelector( 'header' );
		const body = d.querySelector( 'body' );

		body.style.paddingTop = header.offsetHeight + 'px';

		w.addEventListener( 'resize', function() {
			body.style.paddingTop = header.offsetHeight + 'px';
		} );

		header.classList.add( 'fixed-top' ); // class from Bootstrap.
	}
} )( window, document );
