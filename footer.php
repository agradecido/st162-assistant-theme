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

       <footer id="colophon" class="site-footer bg-gray-800 text-white mt-auto">
               <div class="site-info text-center p-4">
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
