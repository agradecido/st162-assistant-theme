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
 * TEMPORAL: Función de diagnóstico para identificar scripts problemáticos
 * TODO: Remover después del diagnóstico
 */
function debug_enqueued_scripts() {
	global $wp_scripts;
	
	if ( ! current_user_can( 'administrator' ) ) {
		return;
	}
	
	echo '<div style="background: #f1f1f1; padding: 20px; margin: 20px; border: 1px solid #ccc; position: fixed; top: 0; right: 0; z-index: 9999; max-width: 400px; max-height: 400px; overflow-y: auto;">';
	echo '<h3>Scripts Problemáticos Detectados:</h3>';
	
	$found_issues = false;
	
	if ( isset( $wp_scripts->queue ) ) {
		foreach ( $wp_scripts->queue as $handle ) {
			if ( isset( $wp_scripts->registered[ $handle ] ) ) {
				$script = $wp_scripts->registered[ $handle ];
				
				// Verificar archivos problemáticos
				if ( strpos( $script->src, 'sass.dart.js' ) !== false ) {
					echo '<strong style="color: red;">⚠️ SASS.DART.JS:</strong><br>';
					echo 'Handle: ' . $handle . '<br>';
					echo 'Src: ' . $script->src . '<br><br>';
					$found_issues = true;
				}
				if ( strpos( $script->src, 'immutable.es.js' ) !== false ) {
					echo '<strong style="color: red;">⚠️ IMMUTABLE.ES.JS:</strong><br>';
					echo 'Handle: ' . $handle . '<br>';
					echo 'Src: ' . $script->src . '<br><br>';
					$found_issues = true;
				}
				if ( strpos( $script->src, 'chatbot.js' ) !== false ) {
					echo '<strong style="color: red;">⚠️ CHATBOT.JS:</strong><br>';
					echo 'Handle: ' . $handle . '<br>';
					echo 'Src: ' . $script->src . '<br><br>';
					$found_issues = true;
				}
			}
		}
	}
	
	if ( ! $found_issues ) {
		echo '<p style="color: green;">No se encontraron scripts problemáticos en la cola actual.</p>';
		
		// Mostrar todos los scripts para debug adicional
		echo '<h4>Todos los scripts enqueueados:</h4>';
		if ( isset( $wp_scripts->queue ) ) {
			foreach ( $wp_scripts->queue as $handle ) {
				if ( isset( $wp_scripts->registered[ $handle ] ) ) {
					$script = $wp_scripts->registered[ $handle ];
					echo '<strong>' . $handle . '</strong>: ' . $script->src . '<br>';
				}
			}
		}
	}
	
	echo '</div>';
}
add_action( 'wp_footer', 'debug_enqueued_scripts' );
