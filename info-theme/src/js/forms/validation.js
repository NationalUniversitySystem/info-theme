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
} )();
