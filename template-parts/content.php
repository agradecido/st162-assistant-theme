<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ST162-Assistant-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8 p-4 sm:p-6 bg-white shadow-md rounded-lg' ); ?>>
	<header class="entry-header mb-4">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title text-3xl font-bold text-dark hover:text-primary transition-colors duration-200">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title text-2xl font-semibold text-dark hover:text-primary transition-colors duration-200"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta text-sm text-neutral mt-2">
				<?php
				st162_assistant_theme_posted_on();
				st162_assistant_theme_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php st162_assistant_theme_post_thumbnail(); ?>

	<div class="entry-content text-neutral leading-relaxed">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'st162-assistant-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4 text-sm text-neutral">' . esc_html__( 'Pages:', 'st162-assistant-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer mt-4 text-sm text-neutral">
		<?php st162_assistant_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
