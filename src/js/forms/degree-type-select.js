/* global InfoAjaxObject */
/**
 * Attach even listeners to degree type/level & program dropdowns
 */
( function( $ ) {
	$( document ).ready( function() {
		$( '.section__form' ).on( 'change', '.field__degree-type select', programsFinder );
	} );

	function programsFinder() {
		const degreeType = $( this ).val();

		$( '.field__program select' ).prop( 'disabled', true );

		$( '.field__program' ).addClass( 'disabled' );

		// Begin our ajax call.
		$.ajax( {
			type: 'POST',
			url: InfoAjaxObject.ajax_url,
			data: {
				degreeType,
				action: 'info_degree_select',
			},
			success( programs ) { // The WP PHP AJAX action returns a list of programs as a string.
				// Remove all previously added programs as options from "Degree Program" select.
				$( '.populate-program-metadata select' ).find( 'option:not([disabled="disabled"])' ).remove();

				// Add all of our program posts as options to the "Degree Program" select.
				$( programs ).appendTo( '.populate-program-metadata select' );

				$( '.populate-program-metadata select' ).append( '<optgroup label="" class="d-none"></optgroup>' );

				$( '.field__program select' ).prop( 'disabled', false );

				$( '.field__program' ).removeClass( 'disabled' );
			},
		} );
	}
} )( jQuery );

