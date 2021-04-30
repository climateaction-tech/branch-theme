<?php
/** Custom posts and custom taxonomies definitions and customisations.
 *
 *  @package Branch
 */

add_action( 'init', 'branch_create_issue_taxonomy' );

add_filter( 'post_link', 'issue_permalink', 10, 3 );
add_filter( 'post_type_link', 'issue_permalink', 10, 3 );

/**
 * Create the new 'issue' taxonomy if we don't already have it.
 */
function branch_create_issue_taxonomy() {
	if ( ! taxonomy_exists( 'issue' ) ) {
		register_taxonomy(
			'issue',
			'post',
			array(
				'hierarchical' => true,
				'label'        => __( 'Issues' ),
				'public'       => true,
				'show_ui'      => true,
				'query_var'    => 'rating',
				'rewrite'      => true,
			)
		);
	}
}


/**
 * Amend all post permalinks to include the issue taxonomy in the URL.
 *
 * @param string  $permalink The post's permalink.
 * @param WP_Post $post_id The post in question.
 * @param bool    $leavename Whether to keep the post name.
 */
function issue_permalink( $permalink, $post_id, $leavename ) {

	if ( strpos( $permalink, '%issue%' ) === false ) :
		return $permalink;
	endif;

	// Get post.
	$post = get_post( $post_id );

	if ( ! $post ) :
		return $permalink;
	endif;

	// Get taxonomy terms.
	$terms = wp_get_object_terms( $post->ID, 'issue' );

	if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) ) :
		$taxonomy_slug = $terms[0]->slug;
	else :
		$taxonomy_slug = 'not-rated';
	endif;

	return str_replace( '%issue%', $taxonomy_slug, $permalink );
}
