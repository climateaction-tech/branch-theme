/**
 * JS functions that power the grid intensity toggle functionality.
 */



tippy('#tooltip', {
	content: 'This site changes its design based on the quantity of fossil fuels on the grid, to stay inside a carbon budget at all times. <a href="issues/issue-1/designing-branch-sustainable-interaction-design-principles/">Learn more</a>',
	allowHTML: true,
	interactive: true,
});


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

	// Change the intensity back to the live value.
	if ( option.value === 'live' ) {

		// Set to immediately expire, which means on reload the core way it fetches intensity is used instead.
		setWithExpiry( 'grid-intensity', 'unset', 0 );
		location.reload();

	} else {
		// Change the intensity to another user selected intensity.
		setWithExpiry( 'grid-intensity', option.value, 3600000 );
		location.reload();
	}
});