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

        <footer id="colophon" class="site-footer bg-dark text-light p-4 text-center mt-8 shadow-inner">
                <div class="site-info text-sm">
				<?php
				printf( esc_html__( 'Proudly powered by %s', 'st162-assistant-theme' ), 'WP API Assistant' );
				?>
			<span class="sep"> | </span>
				<?php
				printf( esc_html__( 'Theme based on ', 'st162-assistant-theme' ), ' <a href="http://underscores.me/">Underscores.me</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
