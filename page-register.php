<?php
/**
 * Template Name: Registro
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

$errors  = array();
$success = false;

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['st162_register_nonce'] ) && wp_verify_nonce( $_POST['st162_register_nonce'], 'st162_register' ) ) {
    $username = sanitize_user( $_POST['username'] );
    $email    = sanitize_email( $_POST['email'] );
    $password = $_POST['password'];

    if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
        $errors[] = __( 'All fields are required.', TEXT_DOMAIN );
    } elseif ( ! is_email( $email ) ) {
        $errors[] = __( 'Invalid email address.', TEXT_DOMAIN );
    } elseif ( username_exists( $username ) ) {
        $errors[] = __( 'Username already exists.', TEXT_DOMAIN );
    } elseif ( email_exists( $email ) ) {
        $errors[] = __( 'Email already registered.', TEXT_DOMAIN );
    }

    if ( empty( $errors ) ) {
        $user_id = wp_create_user( $username, $password, $email );
        if ( ! is_wp_error( $user_id ) ) {
            $success = true;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }
}
?>
<main id="primary" class="site-main container mx-auto p-2 sm:p-4">
    <?php if ( $success ) : ?>
        <p><?php esc_html_e( 'Registration complete. You can now log in.', TEXT_DOMAIN ); ?></p>
    <?php else : ?>
        <?php foreach ( $errors as $error ) : ?>
            <p class="text-red-500"><?php echo esc_html( $error ); ?></p>
        <?php endforeach; ?>
        <form method="post" class="grid gap-4 max-w-md">
            <p>
                <label for="username"><?php esc_html_e( 'Username', TEXT_DOMAIN ); ?></label>
                <input type="text" id="username" name="username" required class="border p-2 w-full">
            </p>
            <p>
                <label for="email"><?php esc_html_e( 'Email', TEXT_DOMAIN ); ?></label>
                <input type="email" id="email" name="email" required class="border p-2 w-full">
            </p>
            <p>
                <label for="password"><?php esc_html_e( 'Password', TEXT_DOMAIN ); ?></label>
                <input type="password" id="password" name="password" required class="border p-2 w-full">
            </p>
            <?php wp_nonce_field( 'st162_register', 'st162_register_nonce' ); ?>
            <p>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2">
                    <?php esc_html_e( 'Register', TEXT_DOMAIN ); ?>
                </button>
            </p>
        </form>
    <?php endif; ?>
</main>
<?php
get_footer();
