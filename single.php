<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ST162-Assistant-theme
 */

get_header();
?>

	<main id="primary" class="site-main container mx-auto p-2 sm:p-4">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle text-neutral">' . esc_html__( 'Previous:', 'st162-assistant-theme' ) . '</span> <span class="nav-title font-semibold text-primary">%title</span>',
					'next_text' => '<span class="nav-subtitle text-neutral">' . esc_html__( 'Next:', 'st162-assistant-theme' ) . '</span> <span class="nav-title font-semibold text-primary">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
