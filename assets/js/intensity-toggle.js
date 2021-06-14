/**
 * JS functions that power the grid intensity toggle functionality.
 */


/**
 * Initialise the select box styling framework.
 * We're using Selectr: https://github.com/Mobius1/Selectr
 * It was the only non JQuery plugin I could find, but sadly its not under active dev anymore.
 */
var selector = new Selectr( '#carbon-switcher-toggle', {
	defaultSelected: false,
	searchable: false,
	width: 260
});

// Attach event listener to the select element.
selector.on('selectr.select', async function(option) {

	// Change the intensity as required.
	if ( option.value === 'live' ) {
		console.log( 'expiry value=', getWithExpiry( 'grid-intensity' ) );
		

		if ( null != getWithExpiry( 'grid-intensity' ) ) {
			index = getWithExpiry( 'grid-intensity' )
			console.log( 'Index=', index );
		} else {
			const grid = new GridIntensity()
			await grid.setup()
			index = await grid.getCarbonIndex()
		}
		
		setWithExpiry( 'grid-intensity', index, 3600000 );
		location.reload();

	} else {
		setWithExpiry( 'grid-intensity', option.value, 3600000 );
		location.reload();
	}
});