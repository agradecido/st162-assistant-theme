<?php
/**
 * Template Name: Login/Register Page
 *
 * This is the template that displays both the login and registration forms.
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Check if user is already logged in.
if ( is_user_logged_in() ) {
	wp_safe_redirect( home_url() );
	exit;
}

// Handle redirect parameter.
$redirect_to = home_url();
if ( isset( $_GET['redirect_to'] ) ) {
	$redirect_to = esc_url_raw( wp_unslash( $_GET['redirect_to'] ) );
}

// Handle messages.
$login_message = '';
$register_message = '';
$message_type = '';

// Login messages.
if ( isset( $_GET['login'] ) ) {
	$message_type = 'error';
	switch ( $_GET['login'] ) {
		case 'failed':
			$login_message = __( 'Login failed. Please check your username and password and try again.', 'st162-assistant-theme' );
			break;
		case 'empty':
			$login_message = __( 'Please enter your username and password.', 'st162-assistant-theme' );
			break;
		case 'false':
			$login_message = __( 'You are now logged out.', 'st162-assistant-theme' );
			$message_type = 'success';
			break;
	}
}

// Registration messages.
if ( isset( $_GET['register'] ) ) {
	switch ( $_GET['register'] ) {
		case 'success':
			$register_message = __( 'Registration successful! You can now log in.', 'st162-assistant-theme' );
			$message_type = 'success';
			break;
		case 'failed':
			$message_type = 'error';
			if ( isset( $_GET['error'] ) ) {
				$error_code = sanitize_text_field( wp_unslash( $_GET['error'] ) );
				switch ( $error_code ) {
					case 'empty_fields':
						$register_message = __( 'Please fill in all required fields.', 'st162-assistant-theme' );
						break;
					case 'username_exists':
						$register_message = __( 'This username already exists. Please choose another one.', 'st162-assistant-theme' );
						break;
					case 'email_exists':
						$register_message = __( 'This email address is already registered.', 'st162-assistant-theme' );
						break;
					case 'creation_failed':
						$register_message = __( 'User creation failed. Please try again.', 'st162-assistant-theme' );
						break;
					default:
						$register_message = __( 'Registration failed. Please try again.', 'st162-assistant-theme' );
						break;
				}
			} else {
				$register_message = __( 'Registration failed. Please try again.', 'st162-assistant-theme' );
			}
			break;
	}
}
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main container mx-auto p-2 sm:p-4" role="main">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title text-center text-2xl font-bold mb-6">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php if ( ! empty( $login_message ) || ! empty( $register_message ) ) : ?>
					<div class="message mb-6 p-4 rounded <?php echo 'success' === $message_type ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'; ?>">
						<?php
						if ( ! empty( $login_message ) ) {
							echo esc_html( $login_message );
						}
						if ( ! empty( $register_message ) ) {
							echo esc_html( $register_message );
						}
						?>
					</div>
				<?php endif; ?>

				<div id="login-register-forms" class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
					<div id="register-form-wrap" class="bg-white p-6 rounded-lg shadow-lg">
						<h2 class="text-xl font-semibold mb-4"><?php esc_html_e( 'Sign up', 'st162-assistant-theme' ); ?></h2>
						<form id="registerform" action="<?php echo esc_url( home_url( '/login' ) ); ?>" method="post">
							<?php wp_nonce_field( 'st162_register_action', 'register_nonce' ); ?>
							<p class="mb-4">
								<label for="user_login" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Username', 'st162-assistant-theme' ); ?></label>
								<input type="text" name="user_login" id="user_login_reg" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="" size="20" required />
							</p>
							<p class="mb-4">
								<label for="user_email" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Email', 'st162-assistant-theme' ); ?></label>
								<input type="email" name="user_email" id="user_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="" size="25" required />
							</p>
							<p class="mb-4">
								<label for="user_pass" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Password', 'st162-assistant-theme' ); ?></label>
								<input type="password" name="user_pass" id="user_pass_reg" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="" size="20" required />
							</p>
							<p class="register-submit">
								<input type="submit" name="wp-submit" id="wp-submit-reg" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php esc_attr_e( 'Register', 'st162-assistant-theme' ); ?>" />
							</p>
						</form>
					</div>
					
					<!-- Separador -->
					<div class="separator hidden md:flex items-center justify-center">
						<div class="bg-gray-300 h-px flex-1"></div>
						<span class="px-4 text-gray-500 font-medium">OR</span>
						<div class="bg-gray-300 h-px flex-1"></div>
					</div>
					
					<div id="login-form-wrap" class="bg-white p-6 rounded-lg shadow-lg">
						<h2 class="text-xl font-semibold mb-4"><?php esc_html_e( 'Sign in', 'st162-assistant-theme' ); ?></h2>
						<form id="loginform" action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
							<p class="mb-4">
								<label for="user_login" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Username or Email Address', 'st162-assistant-theme' ); ?></label>
								<input type="text" name="log" id="user_login" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="" size="20" required />
							</p>
							<p class="mb-4">
								<label for="user_pass" class="block text-sm font-medium text-gray-700 mb-1"><?php esc_html_e( 'Password', 'st162-assistant-theme' ); ?></label>
								<input type="password" name="pwd" id="user_pass" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="" size="20" required />
							</p>
							<p class="login-remember mb-4">
								<label class="flex items-center">
									<input name="rememberme" type="checkbox" id="rememberme" value="forever" class="mr-2" /> 
									<?php esc_html_e( 'Remember Me', 'st162-assistant-theme' ); ?>
								</label>
							</p>
							<p class="login-submit">
								<input type="submit" name="wp-submit" id="wp-submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500" value="<?php esc_attr_e( 'Log In', 'st162-assistant-theme' ); ?>" />
								<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>" />
							</p>
						</form>
						
						<div class="login-links mt-4 text-center">
							<p>
								<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="text-blue-600 hover:text-blue-800 text-sm">
									<?php esc_html_e( 'Lost your password?', 'st162-assistant-theme' ); ?>
								</a>
							</p>
						</div>
					</div>

				</div>
			</div><!-- .entry-content -->
		</article><!-- #post-## -->

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
