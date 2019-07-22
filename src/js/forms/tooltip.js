document.querySelector( 'body' ).addEventListener( 'mouseenter', function( event ) {
	if ( event.target.matches( 'span[data-tool]' ) ) {
		var tooltip = document.querySelector( '.form__group--military .tooltip' );
		tooltip.classList.add( 'show' );
	}
}, true );

document.querySelector( 'body' ).addEventListener( 'mouseleave', function( event ) {
	if ( event.target.matches( 'span[data-tool]' ) ) {
		var tooltip = document.querySelector( '.form__group--military .tooltip' );
		tooltip.classList.remove( 'show' );
	}
}, true );
