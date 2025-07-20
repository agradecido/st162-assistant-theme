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
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'st162-assistant-theme'); ?></a>

		<header id="masthead" class="site-header bg-dark text-light px-4 py-4 flex items-center justify-between relative" style="border: 1px solid lime;">
			<div class="site-branding" style="border: 1px solid lime;">
				<?php
				the_custom_logo();
				if (is_front_page() && is_home()) :
				?>
					<h1 class="site-title text-2xl font-semibold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
				<?php
				else :
				?>
					<p class="site-title text-2xl font-semibold"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
				<?php
				endif;
				$st162_assistant_theme_description = get_bloginfo('description', 'display');
				if ($st162_assistant_theme_description || is_customize_preview()) :
				?>
					<p class="site-description text-sm text-light"><?php echo $st162_assistant_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																	?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation" style="border: 1px solid lime;">
				<button class="menu-toggle md:hidden flex flex-col items-center justify-center w-8 h-8 space-y-1" aria-controls="primary-menu" aria-expanded="false">
					<span class="block w-6 h-0.5 bg-white"></span>
					<span class="block w-6 h-0.5 bg-white"></span>
					<span class="block w-6 h-0.5 bg-white"></span>
					<span class="sr-only"><?php esc_html_e('Primary Menu', 'st162-assistant-theme'); ?></span>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-1',
						'menu_id'         => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->