<?php
/**
 * Custom posts and custom taxonomies definitions.
 *
 *  @package Branch
 */

add_action( 'init', 'branch_create_issue_taxonomy' );


/**
 * Create the new 'issue' taxonomy if we don't already have it.
 */
function branch_create_issue_taxonomy() {
	if ( ! taxonomy_exists( 'issue' ) ) {

		$labels = array(
			'name'              => _x( 'Issues', 'taxonomy general name', 'branch' ),
			'singular_name'     => _x( 'Issue', 'taxonomy singular name', 'branch' ),
			'search_items'      => __( 'Search issues', 'branch' ),
			'all_items'         => __( 'All issues', 'branch' ),
			'parent_item'       => __( 'Parent issue', 'branch' ),
			'parent_item_colon' => __( 'Parent issue:', 'branch' ),
			'edit_item'         => __( 'Edit issue', 'branch' ),
			'update_item'       => __( 'Update issue', 'branch' ),
			'add_new_item'      => __( 'Add new issue', 'branch' ),
			'new_item_name'     => __( 'New issue name', 'branch' ),
			'menu_name'         => __( 'Issues', 'branch' ),
		);

		register_taxonomy(
			'issue',
			'post',
			array(
				'hierarchical' => true,
				'label'        => __( 'Issues', 'branch' ),
				'labels'       => $labels,
				'public'       => true,
				'show_ui'      => true,
				'query_var'    => 'issue',
				'rewrite'      => array(
					'slug'       => 'issues',
					'with_front' => false,
				),
			)
		);
	}
}


