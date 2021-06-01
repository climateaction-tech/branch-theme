<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Branch
 */

get_header();

// Get the current taxonomy term.
$term = get_queried_object();

// Prepare the ACF variables.
$issue_month    = get_field( 'issue_month', $term );
$featured_image = get_field( 'featured_image', $term );
$image_caption  = get_field( 'featured_image_caption', $term );
?>

<main id="primary" class="site-main">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<h1 class="entry-title">
				<?php
				echo esc_html( get_bloginfo( 'description' ) ), ' - ', single_term_title();
				?>
			</h1>
		</header>

		<div class="entry-content">

			<?php
			if ( ! empty( $issue_month ) ) :
				?>

				<h2>
					<?php
					echo esc_html( $issue_month );
					?>
				</h2>

				<?php
			endif;
			?>

			<div class="post-thumbnail">
				<?php

				if ( ! empty( $featured_image ) ) :
					?>

					<figure class="aligncenter wp-block-image">

						<?php
						branch_output_responsive_image_markup( $featured_image['id'], '(max-width: 740px) 100vw, 740px' );
						?>

						<?php
						if ( ! empty( $image_caption ) ) :
							echo wp_kses_post( $image_caption );
						endif;
						?>
					</figure>

					<?php
				endif;
				?>
			</div>

			<?php

			echo wp_kses_post( term_description() );

			?>
		</div>

	</article>
</main><!-- #main -->

<?php
get_footer();
