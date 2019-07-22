/* global getParameterByName, __lc */
/* eslint-disable camelcase */
var utm_source = 'Null';
var utm_medium = 'Null';
var utm_term = 'Null';
var utm_content = 'Null';
var utm_campaign = 'Null';
var track = 'Null';

var us  = getParameterByName( 'utm_source' );
var um  = getParameterByName( 'utm_medium' );
var ut  = getParameterByName( 'utm_term' );
var uct = getParameterByName( 'utm_content' );
var ucm = getParameterByName( 'utm_campaign' );
var tr  = getParameterByName( 'track' );

var ut1  = ut.length > 0 ? ut : utm_term;
var us1  = us.length > 0 ? us : utm_source;
var um1  = um.length > 0 ? um : utm_medium;
var uct1 = uct.length > 0 ? uct : utm_content;
var ucm1 = ucm.length > 0 ? ucm : utm_campaign;
var tr1  = tr.length > 0 ? tr : track;

window.__lc = window.__lc || {};
__lc.license = 1051665;
window.__lc.ga_version = 'ga';
window.__lc.params = [
	{ name: 'track', value: tr1 },
	{ name: 'utm_source', value: us1 },
	{ name: 'utm_medium', value: um1 },
	{ name: 'utm_term', value: ut1 },
	{ name: 'utm_content', value: uct1 },
	{ name: 'utm_campaign', value: ucm1 }
];

( function() {
	var lc = document.createElement( 'script' ); lc.type = 'text/javascript'; lc.async = true;
	lc.src = ( 'https:' === document.location.protocol ? 'https://' : 'http://' ) + 'cdn.livechatinc.com/tracking.js';
	var s = document.getElementsByTagName( 'script' )[0]; s.parentNode.insertBefore( lc, s );

	var newChatButtons = document.querySelectorAll( '.newChat' );
	if ( newChatButtons ) {
		newChatButtons.forEach( function( element ) {
			element.addEventListener( 'click', function( event ) {
				event.preventDefault();

				var liveChatButton = document.querySelector( '.livechat_button a' );
				if ( liveChatButton ) {
					liveChatButton.click();
				}
			} );
		} );
	}
} )();

