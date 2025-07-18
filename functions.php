<?php
/**
 * Branch functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Branch
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '0.1.6' );
}

if ( ! function_exists( 'branch_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function branch_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Branch, use a find and replace
		 * to change 'branch' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'branch', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'branch' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'branch_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'branch_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function branch_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'branch_content_width', 640 );
}
add_action( 'after_setup_theme', 'branch_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function branch_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'branch' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'branch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'branch_widgets_init' );

// Enqueue scripts and styles.
require get_template_directory() . '/inc/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Remove unneeded defaults.
 */
require get_template_directory() . '/inc/remove-defaults.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Create custom posts and taxonomies.
require get_template_directory() . '/inc/custom-posts-and-taxonomies.php';

// Define custom rewrite rules / permalink structure.
require get_template_directory() . '/inc/rewrite_rules.php';

// Functions supporting the contents sidebar / ToC.
require get_template_directory() . '/inc/contents-sidebar.php';

/**
 * Enable upload for webp image files.
 */
function branch_upload_mimes( $existing_mimes ) {
	$existing_mimes['webp'] = 'image/webp';
	return $existing_mimes;
}
add_filter( 'mime_types', 'branch_upload_mimes' );

/**
 * Set color scheme to sunrise for staging users
 */
function set_admin_color_scheme_to_sunrise( $color_scheme ) {
	$color_scheme = 'sunrise';

	return $color_scheme;
}

if ( strpos( get_site_url(), 'staging' ) !== false ) {
	add_filter( 'get_user_option_admin_color', 'set_admin_color_scheme_to_sunrise' );
}

/**
 * Exclude 'Footer' page from admin.
 */
function exclude_footer_page_from_admin( $query ) {
	global $pagenow, $post_type;

	if ( is_admin() && $pagenow === 'edit.php' && $post_type === 'page' ) {
		$footer_page = get_page_by_title( 'Footer' );
		$query->query_vars['post__not_in'] = array( $footer_page->ID );
	}
}
add_filter( 'parse_query', 'exclude_footer_page_from_admin' );

/**
 * Always lazyload images to ensure high-resolution images aren't downloaded
 * during periods of moderate or high carbon intensity.
 */
function always_lazyload_images() {
	return 0;
}
add_filter( 'wp_omit_loading_attr_threshold', 'always_lazyload_images', 10, 0 );
