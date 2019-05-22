
/* global getParameterByName, getCookie */

/**
 * This file builds a query string to attach to anchor links so that we can track data on our other domains.
 */
( function( $ ) {
	var starterQueryString = getStarterString();

	$( 'a' ).prop( 'href', function() {
		const href    = $( this ).attr( 'href' );
		const hrefUrl = this.href;

		if ( href.indexOf( '#' ) === 0 || href.indexOf( 'mailto' === 0 ) ) {
			return href;
		} else if ( hrefUrl.indexOf( '?' ) >= 0 && hrefUrl.indexOf( '#' ) === -1 ) {
			return hrefUrl + '&' + starterQueryString;
		} else if ( hrefUrl.indexOf( '#' ) >= 0 ) {
			return hrefUrl;
		} else if ( hrefUrl.indexOf( '?' ) === -1 && hrefUrl.indexOf( '#' ) === -1 ) {
			return hrefUrl + '?' + starterQueryString;
		}
	} );
} )( jQuery );

function getStarterString() {
	const starter  = window.location.hostname;
	let string     = '';
	let parameters = [];

	const trackersToUse = [
		'utm_source',
		'utm_medium',
		'utm_term',
		'utm_content',
		'utm_campaign',
		'track'
	];

	trackersToUse.forEach( function( tracker ) {
		parameters.push( {
			key: tracker,
			value: getParameterByName( tracker )
		} );
	} );

	const filteredParams = parameters.filter( parameter => parameter.value );

	if ( filteredParams.length ) {
		string = 'start=' + starter;

		filteredParams.forEach( function( parameterObject ) {
			string += '&' + parameterObject.key + '=' + parameterObject.value;
		} );
	} else {
		let cookies = [];

		trackersToUse.forEach( function( tracker ) {
			cookies.push( {
				key: tracker,
				value: getCookie( tracker + '1' )
			} );
		} );

		const filteredCookies = cookies.filter( parameter => parameter.value );

		if ( filteredCookies.length ) {
			string = 'start=' + starter;

			filteredCookies.forEach( function( parameterObject ) {
				string += '&' + parameterObject.key + '=' + parameterObject.value;
			} );
		}
	}

	return string;
}
