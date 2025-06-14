<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ST162-Assistant-theme
 */

?>

<section class="no-results not-found container mx-auto p-2 sm:p-4 text-center">
	<header class="page-header mb-4">
		<h1 class="page-title text-2xl font-bold text-dark"><?php esc_html_e( 'Nothing Found', 'st162-assistant-theme' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content text-neutral leading-relaxed">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p class="mb-4">' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s" class="text-primary hover:underline">Get started here</a>.', 'st162-assistant-theme' ),
					array(
						'a' => array(
							'href' => array(),
							'class' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="mb-4"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'st162-assistant-theme' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p class="mb-4"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'st162-assistant-theme' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
