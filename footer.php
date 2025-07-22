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

<script type="module">
	const infoBar = document.querySelector('gaw-info-bar');
	const shadowRoot = infoBar.shadowRoot
	const toggle = shadowRoot.querySelector('input[type="checkbox"]')
	toggle.addEventListener("change", () => {
	    toggle.checked ? cabin?.event("GAW opt-in") : cabin?.event("GAW opt-out")
	})

	const infoIcon = shadowRoot.querySelector('.popover-wrapper > button')
	infoIcon.addEventListener('click', () => {
		cabin?.event("GAW info clicked")
	});
	
	const body = document.querySelector('body')
	const gawMode = body.getAttribute('data-gaw-mode')
	cabin?.event(`GAW view - ${gawMode}`)
	
	if (!toggle.checked) {
		const lowButton = shadowRoot.querySelector('#gaw-manual-low')
		lowButton.addEventListener('click', () => {
			cabin?.event('GAW user select - Low')
		})
		const moderateButton = shadowRoot.querySelector('#gaw-manual-moderate')
		moderateButton.addEventListener('click', () => {
			cabin?.event('GAW user select - Moderate')
		})
		const highButton = shadowRoot.querySelector('#gaw-manual-high')
		highButton.addEventListener('click', () => {
			cabin?.event('GAW user select - High')
		})

		const defaultButton = shadowRoot.querySelector('#gaw-manual-default')
		defaultButton.addEventListener('click', () => {
			cabin?.event('GAW user select - Default')
		})
	}
</script>

</body>
</html>
