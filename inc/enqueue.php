<?php
/**
 * Understrap enqueue scripts
 *
 * @package branch
 */

/**
 * @param  string  $filename
 * @return string
 */
function asset_path($filename)
{
    $manifest_path = get_stylesheet_directory() . "/rev-manifest.json";
    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
        $manifest = [];
    }

    if (array_key_exists($filename, $manifest)) {
        return $manifest[$filename];
    }
    return $filename;
}

/**
 * Enqueue scripts and styles.
 */
function branch_scripts()
{
    wp_enqueue_style(
        "fonts-css",
        get_template_directory_uri() . "/assets/css/fonts.css",
        [],
        filemtime(get_template_directory() . "/assets/css/fonts.css"),
    );
    wp_enqueue_style(
        "branch-styles",
        get_template_directory_uri() . "/assets/css/theme.min.css",
        [],
        filemtime(get_template_directory() . "/assets/css/theme.min.css"),
    );

    wp_style_add_data("branch-styles", "rtl", "replace");

    wp_enqueue_script(
        "branch-toc",
        get_template_directory_uri() . "/assets/js/branch-toc.min.js",
        [],
        filemtime(get_template_directory() . "/assets/js/branch-toc.min.js"),
        true,
    );
    wp_enqueue_script_module(
        "branch-gaw",
        get_template_directory_uri() . "/assets/js/gaw.js",
        [],
        filemtime(get_template_directory() . "/assets/js/gaw.js"),
        true,
    );
}
add_action("wp_enqueue_scripts", "branch_scripts");
