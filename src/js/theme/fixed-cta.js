import { isVisible, debounce } from './functions';

( function() {
	// Set our vars.
	const fixedCTA = document.getElementById( 'fixed-cta' );

	// Check if our main element exists.
	const triggerField = document.querySelector( '.gform_body' );
	const footer       = document.querySelector( '.footer' );

	/**
	 * On scroll, toggle hide animation class on the fixed-cta element
	 * depending on whether or not the trigger field is visible (includes phone and chat icons).
	 * - Uses debounce so scroll does not hog browser resources
	 */
	const hideFixedCTA = debounce( () => {
		// If elem is visible.
		if ( isVisible( triggerField ) ) {
			// Add our classes.
			fixedCTA.classList.add( 'hide-me' );
			// Prevent overlay showing if zooming on footer.
		} else if ( isVisible( footer ) && ! isVisible( triggerField ) ) {
			// Add our classes.
			fixedCTA.classList.add( 'hide-me' );
		} else {
			// Remove our classes.
			fixedCTA.classList.remove( 'hide-me' );
		}
	}, 150 );

	if ( fixedCTA && ( triggerField || footer ) ) {
		window.addEventListener( 'scroll', hideFixedCTA );
	}
} )();
