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
				<div class="menu-main-menu-es-container">
					<ul id="primary-menu" class="menu nav-menu">
						<li id="menu-item-254" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-2 current_page_item menu-item-254"><a href="http://localhost:8000/es/" aria-current="page">Toyota Celica 4Gen Assistant</a></li>
						<li id="menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-250"><a href="http://localhost:8000/es/contacto/">Contacto</a></li>
						<li id="menu-item-249" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-249"><a href="http://localhost:8000/es/aviso-legal/">Aviso legal</a></li>
						<li id="menu-item-274-en" class="lang-item lang-item-11 lang-item-en lang-item-first menu-item menu-item-type-custom menu-item-object-custom menu-item-274-en"><a href="http://localhost:8000/" hreflang="en-US" lang="en-US">English</a></li>
						<li id="menu-item-274-es" class="lang-item lang-item-8 lang-item-es current-lang menu-item menu-item-type-custom menu-item-object-custom current_page_item menu-item-home menu-item-274-es"><a href="http://localhost:8000/es/" hreflang="es-ES" lang="es-ES">Español</a></li>
					</ul>
				</div>
				<?php
				/** 
			wp_nav_menu(
				array(
					'theme_location'  => 'menu-1',
					'menu_id'         => 'primary-menu',
				)
			); */
				?>
			</nav><!-- #site-navigation -->
		</header><!-- #masthead -->