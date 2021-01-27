( function( d, $ ) { // Anonymous function to pass jQuery object.
	d.addEventListener( 'click', function( event ) { // Method to attach delegated events.
		if ( event.target.matches( '.modal-launch' ) ) {
			event.preventDefault();

			const href = event.target.getAttribute( 'href' );
			$( href ).modal();
		}
	} );
} )( document, jQuery );

