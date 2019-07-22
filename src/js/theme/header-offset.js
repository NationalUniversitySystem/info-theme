( function() {
	if ( document.getElementById( 'masthead' ) !== null ) {
		// Get the header as an object.
		var header = document.getElementById( 'masthead' );

		// Get the height of the header on page load.
		var headerInitHeight = header.offsetHeight + 'px';

		// Get the content area as an object.
		var content = document.getElementById( 'content' );

		// Set padding-top on content area.
		content.style.paddingTop = headerInitHeight;

		// When the browser is resized.
		window.addEventListener( 'resize', function() {

			// Get the height of the header on window resize.
			var headerResizeHeight = header.offsetHeight + 'px';

			// Set padding-top on content area.
			content.style.paddingTop = headerResizeHeight;
		} );
	}
} )();
