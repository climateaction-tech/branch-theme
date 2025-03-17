<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Branch
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/branch_red-01.svg">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preload" href="<?php echo esc_url( get_template_directory_uri() ); ?>/fonts/Rubik-Bold.woff2" as="font" type="font/woff2" crossorigin>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'branch' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="logo">
		<img src="<?php echo esc_url( get_template_directory_uri() );?>/images/branch_red-01.svg" />
		</div>
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$branch_description = get_bloginfo( 'description', 'display' );
			if ( $branch_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $branch_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->

		<div class="site-credit">
			<a class="site-credit__link" href="https://climateaction.tech/">
				<img class="site-credit__image" src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/Climate_Action_Tech_Logo.svg" />
			</a>
		</div>
	</header><!-- #masthead -->

	<div class="secondary-nav">
		<?php
		// We don't want to see the content on any of the global pages.
		// Only articles and the issue archive page.
		if ( 'post' === get_post_type() ) :
			?>
			<div id="nav-contents" class="nav-contents">
				<p><a class="toc-link" href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/Contents_icon.svg" /> Contents</a></p>
			</div>
			<?php
		endif;
		?>

		<?php get_template_part( 'template-parts/carbon-switcher/carbon-switcher' ); ?>
	</div>

	<div class="blackout"></div>

	<div class="table-of-contents">
		<?php display_toc_contents(); ?>
	</div>

	<div class="carbon-intensity">
		<span class="energy"><?php echo file_get_contents( get_template_directory() . '/images/energy.svg' ); ?></span> <span class="intensity">Unknown</span> grid intensity
	</div>
