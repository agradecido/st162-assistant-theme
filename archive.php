<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ST162-Assistant-theme
 */

get_header();
?>

	<main id="primary" class="site-main container mx-auto p-2 sm:p-4">

		<?php if ( have_posts() ) : ?>

			<header class="page-header my-4 p-4 bg-light rounded-md">
				<?php
				the_archive_title( '<h1 class="page-title text-2xl font-bold text-neutral">', '</h1>' );
				the_archive_description( '<div class="archive-description text-neutral mt-2">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;
			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
