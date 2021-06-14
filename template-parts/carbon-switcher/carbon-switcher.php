<?php
/**
 * Reusable template to output the carbon switcher.
 *
 * @package branch
 */

?>
<div class="carbon-switcher">
	<span>
		<span id="tooltip" class="tooltip">?</span>
		Grid 
		<span class="hide-on-mobile">intensity </span>
		view:
	</span>

	<select id="carbon-switcher-toggle" class="select-list__linked select-css">
		<option value="live" selected>live</option>
		<option value="low">Low</option>
		<option value="moderate">Moderate</option>
		<option value="high">High</option>
	</select>

</div>

<?php
