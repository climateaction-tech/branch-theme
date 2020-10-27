<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Branch
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( get_permalink( 546 ) ); ?>">
				<?php echo esc_html__( 'Privacy notice', 'branch' ); ?>
			</a>|
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'branch' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'branch' ), 'WordPress' );
				?>
			</a>
			<!--<span class="sep"> | </span>-->
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				//printf( esc_html__( 'Theme: %1$s by %2$s.', 'branch' ), 'branch', '<a href="https://jacklenox.com">Jack Lenox</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
