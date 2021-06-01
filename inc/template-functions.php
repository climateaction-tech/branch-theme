<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Branch
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function branch_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'branch_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function branch_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'branch_pingback_header' );


/**
 * Generate responsive image output, including srcset attributes
 *
 * @param int $image_id Id of image we wish to generate srcset for.
 * @param string $sizes String of sizes image will be displayed at.
 */
function branch_output_responsive_image_markup( $image_id, $sizes ) {

	$img_src    = wp_get_attachment_image_url( $image_id, 'large' );
	$img_srcset = wp_get_attachment_image_srcset( $image_id, 'large' );
	$img_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	?>

	<img loading="lazy" src="<?php echo esc_attr( $img_src ); ?>" srcset="<?php echo esc_attr( $img_srcset ); ?>" sizes="<?php echo esc_html( $sizes ) ?>" alt="<?php echo esc_html( $img_alt ); ?>">

	<?php
}
