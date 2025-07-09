<?php
/**
 * Understrap enqueue scripts
 *
 * @package understrap
 */

/**
 * @param  string  $filename
 * @return string
 */
function asset_path($filename) {
    $manifest_path = get_stylesheet_directory() .'/rev-manifest.json';
    if ( file_exists($manifest_path ) ) {
        $manifest = json_decode( file_get_contents( $manifest_path ), TRUE );
    } else {
        $manifest = array();
	}

    if ( array_key_exists( $filename, $manifest ) ) {
        return $manifest[$filename];
    }
    return $filename;
}


/**
 * Enqueue scripts and styles.
 */
function branch_scripts() {
	wp_enqueue_style( 'branch-styles', get_template_directory_uri() . '/assets/css/theme.min.css', array(), filemtime( get_template_directory() . '/assets/css/theme.min.css' ) );
	wp_enqueue_style( 'selectr-style', get_template_directory_uri() . '/assets/css/selectr.css', array(), filemtime( get_template_directory() . '/assets/css/selectr.css' ) );
	wp_style_add_data( 'branch-styles', 'rtl', 'replace' );

	wp_enqueue_script( 'branch-toc', get_template_directory_uri() . '/assets/js/branch-toc.min.js', array(), filemtime( get_template_directory() . '/assets/js/branch-toc.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'branch_scripts' );
