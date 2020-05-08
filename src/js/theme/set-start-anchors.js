
import { getParameterByName, getCookie } from './functions';
/**
 * This file builds a query string to attach to anchor links so that we can track data on our other domains.
 */
( function( d ) {
	const starterQueryString = getStarterString();
	const links = d.querySelectorAll( 'a' );

	const externalLinks = [ ...links ].filter( link => link.href && ! ( link.href.startsWith( window.location.href ) || link.getAttribute( 'href' ).match( /^(#|mailto|tel)/ ) ) );

	externalLinks.forEach( link => {
		const hrefUrl = link.href;

		// If the external link has an anchor down link,
		// don't attach the starter string since it'll cause weird browser behavior.
		if ( hrefUrl.indexOf( '#' ) !== -1 ) {
			return;
		}

		if ( hrefUrl.indexOf( '?' ) >= 0 ) {
			link.setAttribute( 'href', hrefUrl + '&' + starterQueryString );
		} else if ( hrefUrl.indexOf( '?' ) === -1 ) {
			link.setAttribute( 'href', hrefUrl + '?' + starterQueryString );
		}
	} );
} )( document );

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
