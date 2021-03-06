import Siema from 'siema';
( function( w ) {
	if ( document.querySelector( '.accolades__wrap' ) !== null ) {
		// Setup our Siema object.
		const mySiema = new Siema( {
			selector: '.accolades__wrap',
			multipleDrag: false,
		} );

		// Initialize our next/prev arrows.
		document.querySelector( '.accolades__nav--prev' ).addEventListener( 'click', () => mySiema.prev() );
		document.querySelector( '.accolades__nav--next' ).addEventListener( 'click', () => mySiema.next() );

		// Get the window width on page load.
		const windowInitWidth = window.innerWidth;

		// If window width is smaller than 768px.
		if ( windowInitWidth < 768 ) {
			// Initialize our slider.
			mySiema.init();
		} else {
			// Destroy the slider, keeping the original markup.
			mySiema.destroy( true );
		}

		// When we resize the browser.
		w.addEventListener( 'resize', function() {
			// Get the newly resized browser width.
			const windowResizeWidth = window.innerWidth;

			// If window width is smaller than 768px.
			if ( windowResizeWidth < 768 ) {
				// Initialize our slider.
				mySiema.init();
			} else {
				// Destroy the slider, keeping the original markup.
				mySiema.destroy( true );
			}
		} );
	}
} )( window );
