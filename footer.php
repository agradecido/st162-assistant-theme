<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ST162-Assistant-theme
 */

?>

	<footer id="colophon" class="site-footer bg-dark text-light py-6 px-4 text-center">
		<div class="site-info text-sm">
				<?php
				// translators: %s: WordPress AI Assistant plugin name.
				printf( esc_html__( 'celica.info is proudly powered by %s', 'st162-assistant-theme' ), 'WP AI Assistant' );
				?>
			<span class="sep"> | </span>
				<?php
				printf( esc_html__( 'Theme based on Underscores.me', 'st162-assistant-theme' ), 'celica.info' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
