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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'st162-assistant-theme' ); ?></a>

        <header id="masthead" class="site-header bg-primary text-white p-4 md:flex md:items-center md:justify-between shadow-lg">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title text-2xl font-semibold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title text-2xl font-semibold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$st162_assistant_theme_description = get_bloginfo( 'description', 'display' );
			if ( $st162_assistant_theme_description || is_customize_preview() ) :
				?>
				<p class="site-description text-sm text-light"><?php echo $st162_assistant_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                        <button class="menu-toggle md:hidden text-white" aria-controls="primary-menu" aria-expanded="false">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'st162-assistant-theme' ); ?></span>
                        </button>
                        <?php
                        wp_nav_menu(
                                array(
                                        'theme_location'  => 'menu-1',
                                        'menu_id'         => 'primary-menu',
                                        'menu_class'      => 'nav-menu',
                                )
                        );
                        ?>
                </nav><!-- #site-navigation -->
	</header><!-- #masthead -->
