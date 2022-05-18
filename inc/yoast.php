<?php
/**
 * Yoast Compatibility File
 *
 * @link https://yoast.com/
 *
 * @package Branch
 */

/**
 * Support Co-Authors in twitter metadata generated by Yoast
 *
 * See: https://github.com/Yoast/wordpress-seo/blob/5c4cb165764c5dac0e222a6483fa18b209cc262c/src/presenters/slack/enhanced-data-presenter.php
 *
 * @param array                  $data         The default Slack labels + data.
 * @param Indexable_Presentation $presentation The indexable presentation object from Yoast.
 *
 * @return array The modified data array
 */
function branch_wpseo_enhanced_slack_data($data, $presentation) {

	if ( function_exists( 'coauthors' ) ) {
		$data['Written by'] = coauthors(null, null, null, null, false);
	}

	return $data;
}
add_filter( 'wpseo_enhanced_slack_data', 'branch_wpseo_enhanced_slack_data', 10, 2 );
