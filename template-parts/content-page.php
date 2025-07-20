<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ST162-Assistant-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8 p-4 sm:p-6 bg-white shadow-md rounded-lg' ); ?>>
	<header class="entry-header mb-4">
		<?php the_title( '<h1 class="entry-title text-3xl font-bold text-dark">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content text-neutral leading-relaxed">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links mt-4 text-sm text-neutral">' . esc_html__( 'Pages:', 'st162-assistant-theme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer mt-4 text-sm text-neutral">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'st162-assistant-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link hover:text-primary transition-colors duration-200">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
