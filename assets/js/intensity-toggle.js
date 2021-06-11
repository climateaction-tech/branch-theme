/**
 * JS functions that power the grid intensity toggle functionality.
 */


document.addEventListener('input', function (event) {

	// Only run on our select menu
	if (event.target.id !== 'carbon-switcher-toggle') return;

	console.log( event.target.value );

	if ( event.target.value === 'live' ) {
		changeGridIntensity( getWithExpiry( 'grid-intensity' ) );
	} else {
		changeGridIntensity( event.target.value );
	}
	
}, false);
