
import { getParameterByName, getCookie } from '../theme/functions';
/**
 * This file builds a query string to attach to anchor links so that we can track data on our other domains.
 */
( function( $ ) {
	const starterQueryString = getStarterString();

	$( 'a' ).prop( 'href', function() {
		const href    = $( this ).attr( 'href' );
		const hrefUrl = this.href;

		if ( href.match( /^(#|mailto|tel)/ ) ) {
			return href;
		} else if ( hrefUrl.indexOf( '#' ) >= 0 ) {
			return hrefUrl;
		} else if ( hrefUrl.indexOf( '?' ) >= 0 && hrefUrl.indexOf( '#' ) === -1 ) {
			return hrefUrl + '&' + starterQueryString;
		} else if ( hrefUrl.indexOf( '?' ) === -1 && hrefUrl.indexOf( '#' ) === -1 ) {
			return hrefUrl + '?' + starterQueryString;
		}
	} );
} )( jQuery );

function getStarterString() {
	let string = 'start=' + window.location.hostname;
	const parameters = [];
	const trackersToUse = [
		'utm_source',
		'utm_medium',
		'utm_term',
		'utm_content',
		'utm_campaign',
		'track',
	];

	trackersToUse.forEach( tracker => {
		parameters.push( {
			key: tracker,
			value: getParameterByName( tracker ),
		} );
	} );

	const filteredParams = parameters.filter( parameter => parameter.value );

	if ( filteredParams.length ) {
		filteredParams.forEach( parameterObject => {
			string += '&' + parameterObject.key + '=' + parameterObject.value;
		} );
	} else {
		const cookies = [];

		trackersToUse.forEach( tracker => {
			cookies.push( {
				key: tracker,
				value: getCookie( tracker + '1' ),
			} );
		} );

		const filteredCookies = cookies.filter( parameter => parameter.value );

		if ( filteredCookies.length ) {
			filteredCookies.forEach( parameterObject => {
				string += '&' + parameterObject.key + '=' + parameterObject.value;
			} );
		}
	}

	return string;
}
