<?php
/**
 * Custom rewrite and permalink rules.
 *
 * @package branch.
 */

// Create 'issue' (custom taxonmy rewrite rules).
add_action( 'init', 'issue_rewrite_tag_and_rewrite_rules', 10, 0 );

// Tell WP how to handle %issue% in permalinks.
add_filter( 'post_link', 'issue_permalink', 10, 3 );


/**
 * Creates the rewrite tag of %issue% and accompanying rewrite rules.
 */
function issue_rewrite_tag_and_rewrite_rules() {

	// Create query_var 'issue' for use in permalink structure.
	// This will link to our custom taxonomy 'issue'.
	add_rewrite_tag( '%issue%', '([^/]+)' );

	// This targets posts.
	// Example url 'branch.climateaction.tech/issue-1/foreword/'.
	// Expects '%issue%' to be added to permalink settings page.
	add_rewrite_rule(
		'([^/]+)/([^/]+)/?$', // String, followed by a string, followed by slash.
		'index.php?issue=$matches[1]&pagename=$matches[2]',
		'bottom'
	);

	// This targets pages.
	// Example pattern 'https://branch.climateaction.tech/about/'.
	// Without this regular pages were 404-ing.
	add_rewrite_rule(
		'([^/]+)/?$', // String followed by slash.
		'index.php?pagename=$matches[1]',
		'bottom'
	);

}


/**
 * Amend all post permalinks to include the issue taxonomy in the URL.
 *
 * @param string  $permalink The post's permalink.
 * @param WP_Post $post The post in question.
 */
function issue_permalink( $permalink, $post ) {

	// Bail if the URL doesn't have %issue% in it.
	if ( strpos( $permalink, '%issue%' ) === false ) :
		return $permalink;
	endif;

	// Get taxonomy terms.
	$terms = wp_get_object_terms( $post->ID, 'issue' );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) ) :
		$taxonomy_slug = $terms[0]->slug;
	else :
		// Needed in case a post hasn't been assigned an issue.
		$taxonomy_slug = 'no-issue';
	endif;

	return str_replace( '%issue%', $taxonomy_slug, $permalink );
}
