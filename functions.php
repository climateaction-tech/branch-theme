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
	define( '_S_VERSION', '0.0.8' );
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

/**
 * Enqueue scripts and styles.
 */
function branch_scripts() {
	wp_enqueue_style( 'branch-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'branch-style', 'rtl', 'replace' );

	//wp_enqueue_script( 'branch-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	//wp_enqueue_script( 'branch-grid', get_template_directory_uri() . '/js/grid-intensity.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'branch_scripts' );

function branch_grid_intensity() {
	?>
		<script src="<?php echo esc_url( get_template_directory_uri() . '/js/gridintensity.browser.min.js' ); ?>"></script>
		<script>
			function setWithExpiry(key, value, ttl) {
				const now = new Date()

				// `item` is an object which contains the original value
				// as well as the time when it's supposed to expire
				const item = {
					value: value,
					expiry: now.getTime() + ttl,
				}
				localStorage.setItem(key, JSON.stringify(item))
			}

			function getWithExpiry(key) {
				const itemStr = localStorage.getItem(key)
				// if the item doesn't exist, return null
				if (!itemStr) {
					return null
				}
				const item = JSON.parse(itemStr)
				const now = new Date()
				// compare the expiry time of the item with the current time
				if (now.getTime() > item.expiry) {
					// If the item is expired, delete the item from storage
					// and return null
					localStorage.removeItem(key)
					return null
				}
				return item.value
			}

			async function main() {
				let index
				if ( null != getWithExpiry( 'grid-intensity' ) ) {
					index = getWithExpiry( 'grid-intensity' )
				} else {
					const grid = new GridIntensity()
					await grid.setup()
					index = await grid.getCarbonIndex()
					setWithExpiry( 'grid-intensity', index, 3600000 )
				}
				let logo
				console.log({ index })
				document.querySelector('body').classList.add(`${index}-grid-intensity`)
				if ( 'high' == index ) {
					logo = 'orange'
				} else if ( 'moderate' == index ) {
					logo = 'blue'
				} else {
					logo = 'green'
				}
				document.querySelector('.logo img').src = '<?php echo esc_url( get_template_directory_uri() . '/images/branch_' ); ?>' + logo + '-01.svg'
			}
			main()
		</script>
	<?php
}
add_action( 'wp_footer', 'branch_grid_intensity' );

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
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

