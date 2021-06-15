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

		<div class="footer-nav">
			<div class="footer-logos">
				<a href="https://calls.ars.electronica.art/prix/winners/8535/" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/AE_AwardforDigitalHumanity2021.png'; ?>" width="320" height="77" alt="ARS Electronica Award for Digital Humanit 2021 logo">
				</a>
			</div>

			<div class="footer-menu">
				<a href="/subscribe-to-branch-magazine">
					<?php echo esc_html__( 'Subscribe to Branch', 'branch' ); ?>
				</a>

				<a href="<?php echo esc_url( get_permalink( 546 ) ); ?>">
					<?php echo esc_html__( 'Privacy notice', 'branch' ); ?>
				</a>
			</div>
		</div><!-- .footer-nav -->

		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'branch' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'branch' ), 'WordPress' );
				?>
			</a>
		</div><!-- .site-info -->
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
