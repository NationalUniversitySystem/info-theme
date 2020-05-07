/* eslint-disable no-unused-vars */
function validateEmail( mail ) {
	if ( /^[-a-z0-9~!$%^&*_=+}{'?]+(.[-a-z0-9~!$%^&*_=+}{'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i.test( mail ) ) {
		return true;
	}
	return false;
}

function isValidPhone( phonenumber ) {
	if ( phonenumber !== '' ) {
		const goodChars = '+- 1234567890().';
		const cnt = phonenumber.replace( /[^0-9]/g, '' ).length;
		if ( cnt < 10 ) {
			return false;
		}
		for ( let i = 0; i < phonenumber.length; i++ ) {
			const c = phonenumber.charAt( i );
			if ( goodChars.indexOf( c ) < 0 ) {
				return false;
			}
		}
		return true;
	}

	return false;
}

function isValidPhoneUS( phonenumber ) {
	phonenumber = phonenumber.replace( /\s+/g, '' );
	if ( phonenumber.length > 9 && phonenumber.match( /^(\+?1-?)?(\([2-9]([02-9]\d|1[02-9])\)|[2-9]([02-9]\d|1[02-9]))-?[2-9]([02-9]\d|1[02-9])-?\d{4}$/ ) ) {
		return true;
	}

	return false;
}

function checkZip( value ) {
	return /^\d{5}$/.test( value );
}

function nameCheck( value ) {
	if ( value.length > 1 && value.match( /^[a-zA-Z, .-]+$/i ) ) {
		return true;
	}

	return false;
}

function clearError( element ) {
	const x = element.id;
	const y = document.activeElement.id;

	element.parentNode.classList.remove( 'gfield_error' );

	if ( x === y ) {
		element.style.borderColor = '#398ece';
		element.style.fontWeight = '700';
		element.title = '';
	} else {
		element.style.borderColor = 'green';
		element.title = '';
	}
}

/**
 * Quick validation functions
 */
function firstNameValidation() {
	if ( this.value !== '' ) {
		if ( nameCheck( this.value ) ) {
			clearError( this );
		} else {
			this.title = 'First name has an invalid character or is too short';
			this.parentNode.classList.add( 'gfield_error' );
			this.focus();
		}
	} else {
		this.parentNode.classList.add( 'gfield_error' );
		this.title = 'First name has an invalid character or is too short';
	}
}

function lastNameValidation() {
	if ( this.value !== '' ) {
		if ( nameCheck( this.value ) ) {
			clearError( this );
		} else {
			this.title = 'Last name has an invalid character or is too short';
			this.parentNode.classList.add( 'gfield_error' );
			this.focus();
		}
	} else {
		this.parentNode.classList.add( 'gfield_error' );
		this.title = 'Last name has an invalid character or is too short';
	}
}

function emailValidation() {
	if ( this.value !== '' ) {
		if ( validateEmail( this.value ) ) {
			clearError( this );
		} else {
			this.title = 'A proper Email is required';
			this.parentNode.classList.add( 'gfield_error' );
			this.focus();
		}
	} else {
		this.parentNode.classList.add( 'gfield_error' );
		this.title = 'Email is required';
	}
}

function phoneValidation() {
	if ( this.value !== '' ) {
		if ( isValidPhoneUS( this.value ) ) {
			clearError( this );
		} else {
			this.title = '';
			this.parentNode.classList.add( 'gfield_error' );
			this.focus();
		}
	} else {
		this.parentNode.classList.add( 'gfield_error' );
		this.title = 'Phone is required';
	}
}

function zipcodeValidation() {
	if ( this.value !== '' ) {
		if ( checkZip( this.value ) ) {
			clearError( this );
		} else {
			this.title = 'A proper zip code is required';
			this.parentNode.classList.add( 'gfield_error' );
			this.focus();
		}
	} else {
		this.parentNode.classList.add( 'gfield_error' );
		this.title = 'Zip is required';
	}
}