<?php
/**
 * Template Name: Login
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

$args = array(
    'redirect' => home_url(),
);
?>
<main id="primary" class="site-main container mx-auto p-2 sm:p-4">
    <?php wp_login_form( $args ); ?>
</main>
<?php
get_footer();
