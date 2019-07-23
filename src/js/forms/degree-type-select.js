/* global InfoAjaxObject */
/**
 * Attach even listeners to degree type/level & program dropdowns
 */
( function( $ ) {
	$( document ).ready( function() {
		$( '.info-section__form' ).on( 'change', '.field__degree-type select', programsFinder );
	} );

	function programsFinder() {
		var degreeType = $( this ).val();

		// Begin our ajax call.
		$.ajax( {
			type: 'POST',
			url: InfoAjaxObject.ajax_url,
			data: {
				degreeType: degreeType,
				action: 'info_degree_select'
			},
			success: function( programs ) { // The WP PHP AJAX action returns a list of programs as a string.
				// Remove all previously added programs as options from "Degree Program" select.
				$( '.populate-program-metadata select' ).find( 'option:not([disabled="disabled"])' ).remove();

				// Add all of our program posts as options to the "Degree Program" select.
				$( programs ).appendTo( '.populate-program-metadata select' );

				$( '.populate-program-metadata select' ).append( '<optgroup label="" class="d-none"></optgroup>' );
			}
		} );
	}
} )( jQuery );

