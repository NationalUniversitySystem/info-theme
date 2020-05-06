( function( d ) {
	const tooltip = d.querySelector( '.form__group--military .tooltip' );

	if ( tooltip ) {
		d.querySelector( 'body' ).addEventListener( 'mouseenter', function( event ) {
			if ( event.target.matches( 'span[data-tool]' ) ) {
				tooltip.classList.add( 'show' );
			}
		}, true );

		d.querySelector( 'body' ).addEventListener( 'touchstart', function( event ) {
			if ( event.target.matches( 'span[data-tool]' ) ) {
				tooltip.classList.add( 'show' );
			}
		}, true );

		d.querySelector( 'body' ).addEventListener( 'mouseleave', function( event ) {
			if ( event.target.matches( 'span[data-tool]' ) ) {
				tooltip.classList.remove( 'show' );
			}
		}, true );

		d.querySelector( 'body' ).addEventListener( 'touchstart', function( event ) {
			if ( ! event.target.matches( 'span[data-tool]' ) ) {
				tooltip.classList.remove( 'show' );
			}
		}, true );
	}
} )( document );
