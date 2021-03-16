/**
 * This file builds a query string to attach to anchor links so that we can track data on our other domains.
 */
( function( d ) {
	const starterQueryString = 'start=' + window.location.hostname;
	const links = d.querySelectorAll( 'a' );
	const externalLinks = [];

	// Not using spread/ES6 methods due to a babel script breaking IE11.
	links.forEach( link => {
		if ( link.href && ! ( link.href.startsWith( window.location.origin ) || link.getAttribute( 'href' ).match( /^(#|mailto|tel)/ ) ) ) {
			externalLinks.push( link );
		}
	} );

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
