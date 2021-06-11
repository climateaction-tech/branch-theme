/**
 * JS functions that power the grid intensity toggle functionality.
 */


// document.addEventListener('input', function (event) {

// 	console.log( event.target );

// 	// Only run on our select menu.
// 	if (event.target.id !== 'carbon-switcher-toggle') return;

// 	// Change the intensity as required.
// 	if ( event.target.value === 'live' ) {
// 		changeGridIntensity( getWithExpiry( 'grid-intensity' ) );
// 	} else {
// 		changeGridIntensity( event.target.value );
// 	}
	
// }, false);


/**
 * Initialise the select box styling framework.
 * We're using Selectr: https://github.com/Mobius1/Selectr
 * It was the only non JQuery plugin I could find, but sadly its not under active dev anymore.
 */
var selector = new Selectr( '#carbon-switcher-toggle', {
	searchable: false,
	width: 300
});

// Attach event listener to the select element.
selector.on('selectr.select', function(option) {
	console.log( option );

	// Change the intensity as required.
	if ( option.value === 'live' ) {
		changeGridIntensity( getWithExpiry( 'grid-intensity' ) );
	} else {
		changeGridIntensity( option.value );
	}
});