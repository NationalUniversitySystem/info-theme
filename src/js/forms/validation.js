/* global isValidPhoneUS, clearError */
( function() {
	const gForms = document.querySelectorAll( '.gform_wrapper' );

	gForms.forEach( function( element ) {
		element.addEventListener( 'blur', function( event ) {
			let validationFunctionString = '';

			switch ( true ) {
				case event.target.matches( '.field__first-name input' ) :
					validationFunctionString = 'firstNameValidation';
					break;
				case event.target.matches( '.field__last-name input' ) :
					validationFunctionString = 'lastNameValidation';
					break;
				case event.target.matches( '.field__email-address input' ) :
					validationFunctionString = 'emailValidation';
					break;
				case event.target.matches( '.field__phone-number input' ) :
					validationFunctionString = 'phoneValidation';
					break;
				case event.target.matches( '.field__zip-code input' ) :
					validationFunctionString = 'zipcodeValidation';
					break;
			}

			const validationFunction = window[ validationFunctionString ];
			if ( 'function' === typeof validationFunction ) {
				event.target.addEventListener( 'blur', validationFunction, true );
				event.target.addEventListener( 'keyup', validationFunction, true );
			}
		}, true );

	} );

	// Phone validation.
	document.addEventListener( 'keyup', function( e ) {
		if ( e.target.parentNode.classList.contains( 'field__phone-number' ) ) {
			phoneValidation( e.target );
		}
	} );

	document.addEventListener( 'focusin', function( e ) {
		if ( e.target.parentNode.classList.contains( 'field__phone-number' ) ) {
			phoneValidation( e.target );
		}
	} );

	// Uses jQuery because the 'gform_post_render' hook only works with jQuery.

	// We use this to trigger a focus event on the input after failed validation,
	// then quickly un-focus, which in turn starts the phoneValidation function.
	jQuery( document ).ready( function( $ ) {
		$( document ).on( 'gform_post_render', function() {
			$( '.field__phone-number input' ).focus().blur();
		} );
	} );

	function phoneValidation( element ) {

		if ( element.value !== '' ) {
			if ( isValidPhoneUS( element.value ) ) {
				clearError( element );
			} else {
				element.title = '';
				element.parentNode.classList.add( 'gfield_error' );
				element.focus();
			}
		} else {
			element.parentNode.classList.add( 'gfield_error' );
			element.title = 'Phone is required';
		}
	}

} )();
