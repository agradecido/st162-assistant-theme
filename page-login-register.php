<?php
/**
 * Template Name: Login/Register Page
 *
 * This is the template that displays both the login and registration forms.
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div id="login-register-forms">
                    <div id="login-form-wrap">
                        <h2><?php _e( 'Login', 'st162-assistant-theme' ); ?></h2>
                        <form id="loginform" action="<?php echo wp_login_url(); ?>" method="post">
                            <p>
                                <label for="user_login"><?php _e( 'Username or Email Address', 'st162-assistant-theme' ); ?></label>
                                <input type="text" name="log" id="user_login" class="input" value="" size="20" />
                            </p>
                            <p>
                                <label for="user_pass"><?php _e( 'Password', 'st162-assistant-theme' ); ?></label>
                                <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" />
                            </p>
                            <p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember Me', 'st162-assistant-theme' ); ?></label></p>
                            <p class="login-submit">
                                <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php esc_attr_e( 'Log In', 'st162-assistant-theme' ); ?>" />
                                <input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />
                            </p>
                        </form>
                    </div>

                    <div id="register-form-wrap">
                        <h2><?php _e( 'Register', 'st162-assistant-theme' ); ?></h2>
                        <form id="registerform" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post">
                            <p>
                                <label for="user_login"><?php _e( 'Username', 'st162-assistant-theme' ); ?></label>
                                <input type="text" name="user_login" id="user_login_reg" class="input" value="" size="20" />
                            </p>
                            <p>
                                <label for="user_email"><?php _e( 'Email', 'st162-assistant-theme' ); ?></label>
                                <input type="email" name="user_email" id="user_email" class="input" value="" size="25" />
                            </p>
                            <p>
                                <label for="user_pass"><?php _e( 'Password', 'st162-assistant-theme' ); ?></label>
                                <input type="password" name="user_pass" id="user_pass_reg" class="input" value="" size="20" />
                            </p>
                            <p class="register-submit">
                                <input type="submit" name="wp-submit" id="wp-submit-reg" class="button button-primary" value="<?php esc_attr_e( 'Register', 'st162-assistant-theme' ); ?>" />
                            </p>
                        </form>
                    </div>
                </div>
            </div><!-- .entry-content -->
        </article><!-- #post-## -->

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
