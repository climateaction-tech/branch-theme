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

	/* Footer scripts */
	// First two need to go first or seems to break stuff.
	wp_enqueue_script( 'popperjs', 'https://unpkg.com/@popperjs/core@2', array(), '2.9.2', true );
	wp_enqueue_script( 'tippyjs', 'https://unpkg.com/tippy.js@6', array(), '6.3.1', true );

	wp_enqueue_script( 'intensity-toggle', get_template_directory_uri() . '/assets/js/intensity-toggle.js', array( 'selectr' ), filemtime( get_template_directory() . '/assets/js/intensity-toggle.js' ), true );
	wp_enqueue_script( 'selectr', get_template_directory_uri() . '/assets/js/selectr.js', array(), filemtime( get_template_directory() . '/assets/js/selectr.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'branch_scripts' );
