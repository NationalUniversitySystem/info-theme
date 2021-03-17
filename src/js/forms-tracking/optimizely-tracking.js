import { setInputValue } from '../theme/functions';
/**
 * Fetch the optimizely info we want to track and place it into our forms to track,
 * if the appropriate fields exist.
 */
( function( w ) {
	// Check if optimizely is even present.
	if ( 'undefined' === typeof w.optimizely && 'undefined' === typeof w.optimizelyEdge ) {
		return;
	}

	// Get the experiments depending on which version is being used
	// and then manipulate the returned object for use on our hand-off in our forms.
	let activeExperiments = ( 'undefined' !== typeof w.optimizelyEdge ) ? w.optimizelyEdge.get( 'state' ).getActiveExperiments() : w.optimizely.get( 'state' ).getCampaignStates( { isActive: true } );

	activeExperiments = formatExperiments( activeExperiments );

	const forms = document.querySelectorAll( 'form' );

	if ( activeExperiments.length > 0 && forms.length ) {
		// Truncate the string since the systems we'll be sending this to have a character limit.
		const optimizelyTrackString = activeExperiments.join( ',' ).substring( 0, 255 );

		for ( let formIndex = 0; formIndex < forms.length; formIndex++ ) {
			const theForm = forms[ formIndex ];

			setInputValue( '.track_optimizely', optimizelyTrackString, theForm );
		}
	}

	function formatExperiments( fullObject ) {
		const experimentsObject = [];

		for ( const campaignId in fullObject ) {
			const theCampaign = fullObject[ campaignId ];
			const experimentId = theCampaign.experiment ? theCampaign.experiment.id : theCampaign.id;

			experimentsObject.push( experimentId + '|' + theCampaign.variation.id );
		}

		return experimentsObject;
	}
} )( window );
