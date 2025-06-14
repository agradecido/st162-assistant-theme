<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ST162-Assistant-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-gray-50 text-gray-900' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site min-h-screen flex flex-col">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'st162-assistant-theme' ); ?></a>

       <header id="masthead" class="site-header bg-gradient-to-r from-primary via-secondary to-accent text-white">
               <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between p-4">
               <div class="site-branding mb-4 md:mb-0 text-center md:text-left">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$st162_assistant_theme_description = get_bloginfo( 'description', 'display' );
			if ( $st162_assistant_theme_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $st162_assistant_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'st162-assistant-theme' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
               </nav><!-- #site-navigation -->
               </div>
       </header><!-- #masthead -->
