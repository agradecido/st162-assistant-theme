<?php
/**
 * ST162-Assistant-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ST162-Assistant-theme
 */

use Avifinfo\Tile;

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', '1.0.0' );
}

if ( ! defined( 'TEXT_DOMAIN' ) ) {
	define( 'TEXT_DOMAIN', 'st162-assistant-theme' );
}

if ( ! defined( 'LOGIN_LINK_CLASS' ) ) {
	define( 'LOGIN_LINK_CLASS', 'login-button' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function st162_assistant_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on ST162-Assistant-theme, use a find and replace
		* to change TEXT_DOMAIN to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'st162-assistant-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'st162-assistant-theme' ),
		)
	);


	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'st162_assistant_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support( 'block-templates' );
	add_theme_support( 'block-patterns' );
}
add_action( 'after_setup_theme', 'st162_assistant_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function st162_assistant_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'st162_assistant_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'st162_assistant_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function st162_assistant_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', TEXT_DOMAIN ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', TEXT_DOMAIN ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'st162_assistant_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function st162_assistant_theme_scripts() {
	wp_enqueue_style( 'st162-assistant-theme-style', get_stylesheet_uri(), array(), THEME_VERSION );

	wp_enqueue_script( 'st162-assistant-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'st162_assistant_theme_scripts' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Redirect classic WordPress login page to custom login page
 */
function st162_redirect_login_page() {
	// No redirigir si es área de admin o ya está logueado
	if ( is_admin() || is_user_logged_in() ) {
		return;
	}

	// Solo en peticiones GET (permitir POST para procesar login)
	if ( 'POST' === strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		return;
	}

	// Detectar wp-login.php sin action (ni logout, lostpassword…)
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$page = basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );
		if ( 'wp-login.php' === $page && ! isset( $_GET['action'] ) ) {
			// Si vienen con redirect_to apuntando a wp-admin, no redirigir
			if ( isset( $_GET['redirect_to'] ) && false !== strpos( wp_unslash( $_GET['redirect_to'] ), 'wp-admin' ) ) {
				return;
			}
			wp_safe_redirect( home_url( '/login' ) );
			exit();
		}
	}
}
add_action( 'init', 'st162_redirect_login_page', 0 );

function st162_login_redirect( $redirect_to, $request, $user ) {
	// Si hubo error, dejamos el comportamiento por defecto
	if ( is_wp_error( $user ) || ! $user instanceof WP_User ) {
		return $redirect_to;
	}

	// Admin al dashboard
	if ( user_can( $user, 'manage_options' ) ) {
		return admin_url();
	}

	// Resto a home
	return home_url();
}
add_filter( 'login_redirect', 'st162_login_redirect', 10, 3 );

/**
 * Redirect after logout to custom login page
 */
function st162_logout_redirect() {
	wp_safe_redirect( home_url( '/login' ) );
	exit();
}
add_action( 'wp_logout', 'st162_logout_redirect' );

/**
 * Redirect failed logins to custom login page with error
 */
function st162_login_failed() {
	wp_safe_redirect( home_url( '/login?login=failed' ) );
	exit();
}
add_action( 'wp_login_failed', 'st162_login_failed' );

/**
 * Redirect when login form is empty
 *
 * @param WP_User|WP_Error|null $user     User object or error.
 * @param string                $username Username for authentication.
 * @param string                $password Password for authentication.
 * @return WP_User|WP_Error|null
 */
function st162_verify_username_password( $user, $username, $password ) {
	if ( '' === $username || '' === $password ) {
		wp_safe_redirect( home_url( '/login?login=empty' ) );
		exit();
	}
	return $user;
}
add_filter( 'authenticate', 'st162_verify_username_password', 1, 3 );

/**
 * Handle custom registration form processing
 */
function st162_handle_registration() {
	if ( ! isset( $_POST['wp-submit'] ) || ! isset( $_POST['user_login'] ) || ! isset( $_POST['user_email'] ) ) {
		return;
	}

	// Verify nonce if present.
	if ( isset( $_POST['register_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['register_nonce'] ) ), 'st162_register_action' ) ) {
		wp_safe_redirect( home_url( '/login?register=failed&error=nonce_failed' ) );
		exit();
	}

	// Basic validation.
	$username = sanitize_user( wp_unslash( $_POST['user_login'] ) );
	$email    = sanitize_email( wp_unslash( $_POST['user_email'] ) );
	$password = isset( $_POST['user_pass'] ) ? sanitize_text_field( wp_unslash( $_POST['user_pass'] ) ) : '';

	if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
		wp_safe_redirect( home_url( '/login?register=failed&error=empty_fields' ) );
		exit();
	}

	if ( username_exists( $username ) ) {
		wp_safe_redirect( home_url( '/login?register=failed&error=username_exists' ) );
		exit();
	}

	if ( email_exists( $email ) ) {
		wp_safe_redirect( home_url( '/login?register=failed&error=email_exists' ) );
		exit();
	}

	// Create user.
	$user_id = wp_create_user( $username, $password, $email );

	if ( is_wp_error( $user_id ) ) {
		wp_safe_redirect( home_url( '/login?register=failed&error=creation_failed' ) );
		exit();
	}

	// Success.
	wp_safe_redirect( home_url( '/login?register=success' ) );
	exit();
}
add_action( 'init', 'st162_handle_registration' );


/**
 * Replace login button with username in menu
 *
 * @param array  $items Menu items.
 * @param object $args Menu arguments.
 * @return array Modified menu items.
 */
function replace_login_button_with_username( $items, $args ) {
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		foreach ( $items as $item ) {
			if ( in_array( LOGIN_LINK_CLASS, $item->classes, true ) ) {
				// $item->title = esc_html( $current_user->display_name );
				$item->title = 'Logout';
				$item->url   = wp_logout_url( home_url() );
			}
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'replace_login_button_with_username', 10, 2 );

/**
 * Set custom thumbnail size for the theme
 *
 * @return array Thumbnail size configuration.
 */
function st162_assistant_theme_thumbnail_size() {
	return array(
		'width'  => 250,
		'height' => 117,
		'crop'   => false,
	);
}
add_filter( 'st162_assistant_theme_thumbnail_size', 'st162_assistant_theme_thumbnail_size' );

/**
 * Enqueue script for language switcher dropdown functionality
 */
function enqueue_language_switcher_script() {
	?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add debugging to see what we're working with
    console.log('Language switcher script loaded');

    // Find all language items with more specific selectors
    const langItems = document.querySelectorAll(
        '.lang-item, [class*="lang-item"], .pll-parent-menu-item .sub-menu li');
    console.log('Found language items:', langItems.length, langItems);

    // Also check for Polylang parent container
    const polylangParent = document.querySelector('.pll-parent-menu-item, [href="#pll_switcher"]');
    let parentContainer = null;
    if (polylangParent) {
        parentContainer = polylangParent.closest('li');
        console.log('Found Polylang parent container:', parentContainer);
    }

    if (langItems.length > 1 || parentContainer) {
        // Find the current language item - prioritize current-lang over lang-item-first
        let currentLang = document.querySelector('.current-lang') ||
            document.querySelector('.lang-item-first') ||
            document.querySelector('.lang-item.current') ||
            langItems[0];
        console.log('Current language:', currentLang);

        // Double-check: if we found a current-lang item, use it
        const currentLangItem = document.querySelector('.current-lang');
        if (currentLangItem) {
            currentLang = currentLangItem;
        }

        console.log('Final current language selected:', currentLang);

        // Get the parent menu - use parentContainer if available, otherwise current language parent
        const menuContainer = parentContainer ? parentContainer.parentNode : currentLang.parentNode;

        // Create dropdown container
        const dropdown = document.createElement('li');
        dropdown.className = 'menu-item menu-item-language-dropdown';

        // Get the current language link content
        const currentLangLink = currentLang.querySelector('a');
        if (!currentLangLink) {
            console.log('No link found in current language item');
            return;
        }

        dropdown.innerHTML = `
			<a href="#" class="language-current">
				${currentLangLink.innerHTML} <span class="dropdown-arrow">▼</span>
			</a>
			<ul class="language-dropdown-menu"></ul>
		`;

        // Add other languages to dropdown
        const dropdownMenu = dropdown.querySelector('.language-dropdown-menu');
        let addedCount = 0;
        langItems.forEach(function(item) {
            if (item !== currentLang) {
                console.log('Adding language item to dropdown:', item);
                const dropdownItem = document.createElement('li');
                dropdownItem.className = 'language-dropdown-item';
                const itemLink = item.querySelector('a');
                if (itemLink) {
                    dropdownItem.innerHTML = itemLink.outerHTML;
                    dropdownMenu.appendChild(dropdownItem);
                    addedCount++;
                }
            } else {
                console.log('Skipping current language item:', item);
            }
        });
        console.log('Total languages added to dropdown:', addedCount);

        // Replace the first language item with our dropdown
        const insertionPoint = parentContainer || currentLang;
        menuContainer.insertBefore(dropdown, insertionPoint);

        // Remove all original language items AND their parent container if it exists
        langItems.forEach(function(item) {
            if (item.parentNode) {
                item.parentNode.removeChild(item);
            }
        });

        // Also remove any Polylang parent menu item (the one with #pll_switcher)
        if (parentContainer && parentContainer.parentNode) {
            console.log('Removing Polylang parent container:', parentContainer);
            parentContainer.parentNode.removeChild(parentContainer);
        } else {
            // Fallback: try to find and remove by selector
            const polylangParentFallback = document.querySelector(
                '.pll-parent-menu-item, [href="#pll_switcher"]');
            if (polylangParentFallback) {
                const parentLi = polylangParentFallback.closest('li');
                if (parentLi && parentLi.parentNode) {
                    console.log('Removing Polylang parent container (fallback):', parentLi);
                    parentLi.parentNode.removeChild(parentLi);
                }
            }
        }

        // Add click handler to prevent default on dropdown trigger
        const languageCurrent = dropdown.querySelector('.language-current');
        if (languageCurrent) {
            languageCurrent.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('active');
                console.log('Dropdown toggled, active:', dropdown.classList.contains('active'));
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        console.log('Language dropdown created successfully');
    } else {
        console.log('Not enough language items found to create dropdown');
    }
});
</script>

<style>
/* Language dropdown styles */
.menu-item-language-dropdown {
    position: relative;
    display: inline-block;
}

.language-current {
    display: flex;
    align-items: center;
    cursor: pointer;
    text-decoration: none !important;
    padding: 0.5rem 1rem;
    color: inherit;
    transition: color 0.3s ease;
}

.language-current:hover {
    text-decoration: none !important;
    color: inherit;
}

.dropdown-arrow {
    margin-left: 8px;
    font-size: 10px;
    transition: transform 0.2s ease;
    display: inline-block;
    color: currentColor;
}

.menu-item-language-dropdown.active .dropdown-arrow {
    transform: rotate(180deg);
}

.language-dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    transform: translateY(-10px);
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    min-width: 160px;
    list-style: none;
    margin: 0;
    padding: 0;
    opacity: 0;
    transition: all 0.2s ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.menu-item-language-dropdown.active .language-dropdown-menu {
    display: flex;
    flex-direction: column;
    opacity: 1;
    transform: translateY(0);
}

.menu-item-language-dropdown:hover .language-dropdown-menu {
    display: flex;
    flex-direction: column;
    opacity: 1;
    transform: translateY(0);
}

.language-dropdown-item {
    margin: 0;
    display: block;
    width: 100%;
}

.language-dropdown-item a {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-bottom: 1px solid #f0f0f0;
    color: #333;
    transition: background-color 0.2s ease;
    white-space: nowrap;
}

.language-dropdown-item:first-child a {
    border-radius: 6px 6px 0 0;
}

.language-dropdown-item:last-child a {
    border-bottom: none;
    border-radius: 0 0 6px 6px;
}

.language-dropdown-item a:hover {
    background: #f8f9fa;
    text-decoration: none;
    color: #333;
}

.language-dropdown-item img {
    margin-right: 8px;
    flex-shrink: 0;
}

/* Ensure flags display correctly */
.language-current img,
.language-dropdown-item img {
    width: 16px;
    height: 11px;
    vertical-align: middle;
    border-radius: 2px;
}

/* Match the theme's menu styling */
#primary-menu .menu-item-language-dropdown a {
    color: inherit;
}

/* Make sure it integrates well with the existing menu */
.menu-item-language-dropdown {
    margin: 0;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .language-dropdown-menu {
        position: static;
        display: flex !important;
        flex-direction: column !important;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: none;
        opacity: 1;
        transform: none;
        transition: none;
        margin-top: 0.5rem;
        border-radius: 4px;
    }

    .menu-item-language-dropdown.active .dropdown-arrow {
        transform: rotate(0deg);
    }

    .language-dropdown-item {
        display: block;
        width: 100%;
    }

    .language-dropdown-item a {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: transparent;
        color: inherit;
        display: flex;
        width: 100%;
    }

    .language-dropdown-item a:hover {
        background: rgba(255, 255, 255, 0.1);
        color: inherit;
    }
}

/* Dark theme compatibility */
@media (prefers-color-scheme: dark) {
    .language-dropdown-menu {
        background: #2d3748;
        border-color: #4a5568;
    }

    .language-dropdown-item a {
        color: #e2e8f0;
        border-bottom-color: #4a5568;
    }

    .language-dropdown-item a:hover {
        background: #4a5568;
        color: #e2e8f0;
    }
}

/* Ensure proper positioning relative to menu */
@media (min-width: 769px) {
    .language-dropdown-menu {
        left: 0;
        right: auto;
        transform: translateY(-10px);
        min-width: 180px;
    }

    .menu-item-language-dropdown.active .language-dropdown-menu,
    .menu-item-language-dropdown:hover .language-dropdown-menu {
        transform: translateY(0);
    }

    /* If dropdown is too close to right edge, position it to the left */
    .menu-item-language-dropdown:last-child .language-dropdown-menu,
    .menu-item-language-dropdown:nth-last-child(2) .language-dropdown-menu {
        left: auto;
        right: 0;
    }
}
</style>
<?php
}
add_action( 'wp_head', 'enqueue_language_switcher_script' );