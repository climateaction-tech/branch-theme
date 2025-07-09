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

		<?php
		$footer_page = get_page_by_title( 'Footer' );
		$footer_output = apply_filters( 'the_content', $footer_page->post_content );

		echo $footer_output;
		?>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<script async defer src="https://scripts.withcabin.com/hello.js"></script>

</body>
</html>
