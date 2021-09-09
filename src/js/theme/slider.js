( function( d ) {
	/**
	 * Add span elements to checkbox labels
	 *
	 * @param {Object} event  The Javascript event object.
	 * @param {string} formId The ID of the form in use.
	 */

	d.ongform_post_render = function( event, formId ) {
		const elementsToAddSliderTo = [
			'#gform_wrapper_' + formId + ' .form__label--checkbox',
			'#gform_wrapper_' + formId + ' .form__group--military ul label',
			'#gform_wrapper_' + formId + ' .ginput_container_consent label',
		];

		elementsToAddSliderTo.forEach( function( domString ) {
			const domElement = document.querySelector( domString );

			if ( domElement ) {
				const span     = document.createElement( 'span' );
				span.className = 'slider';

				domElement.appendChild( span );
			}
		} );
	};
} )( document );
