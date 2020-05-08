/**
 * Check if form is in the viewport
 */

// Function to check if element is visible in the viewport.
function isVisible( ele ) {
	const { top, bottom } = ele.getBoundingClientRect();
	const vHeight = ( window.innerHeight || document.documentElement.clientHeight );

	return (
		( top > 0 || bottom > 0 ) &&
		top < vHeight
	);
}

// Set our vars.
var fixedCTA = document.getElementById( 'fixed-cta' );

// Check if our main element exists.
const triggerField = document.querySelector( '.form__terms' );
const footer       = document.querySelector( '.footer' );

if ( fixedCTA && triggerField ) {
	// On scroll.
	window.addEventListener( 'scroll', function() {
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
	} );
}


/**
 * Add span elements to checkbox labels
 */
jQuery( document ).on( 'gform_post_render', function() {
	const elementsToAddSliderTo = [
		'.form__label--checkbox',
		'.form__group--military ul label',
		'.ginput_container_consent label'
	];

	elementsToAddSliderTo.forEach( function( domString ) {
		const domElement = document.querySelector( domString );

		if ( domElement ) {
			const span = document.createElement( 'span' );
			span.className = 'slider';

			domElement.appendChild( span );
		}
	} );
} );
