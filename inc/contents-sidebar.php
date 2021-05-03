<?php
/**
 * Functions to support the TOC sidebar.
 *
 * @package branch
 */

/**
 * Dynamically detect the page type and serve the correct TOC contents.
 */
function display_toc_contents() {
	global $post;

	if ( is_singular( 'post' ) ) :

		// Get taxonomy terms.
		$terms = wp_get_object_terms( $post->ID, 'issue' );

		// Output if there's a term and no errors.
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) ) :
			echo term_description( $terms[0]->term_id, 'issue' );
		endif;

	elseif ( is_tax( 'issue' ) ) :

		// Output taxonomy description.
		echo term_description( get_queried_object_id(), 'issue' );

	else :
		// $toc = get_page_by_title( 'contents' );
		// echo apply_filters( 'the_content', $toc->post_content );
		//echo 'What should we output here?';

		$issues = get_terms(
			'issue',
			array(
				'orderby'    => 'ASC',
				'hide_empty' => 0,
			),
		);

		if ( ! empty( $issues ) && ! is_wp_error( $issues ) ) {

			foreach ( $issues as $term ) {
				echo '<h2><a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) . '">' . esc_html( $term->name ) . '</a></h2>';
			}
		}

	endif;
}
