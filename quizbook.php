<?php
/**
 * Plugin Name: Quizbook
 * Plugin URI: https://github.com/mikemarquez11/
 * Description: Add quizzes and exams to your website.
 * Author: MikeMarquez
 * AUthor URI: https://github.com/mikemarquez11/
 * Version: 1.0.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: quizbook
 */

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'QUIZBOOK_VERSION', '1.0.0' );
define( 'QUIZBOOK_STABLE_VERSION', '1.0.0');

define( 'QUIZBOOK__FILE__', __FILE__ );
define( 'QUIZBOOK_PLUGIN_BASE', plugin_basename( QUIZBOOK__FILE__ ) );
define( 'QUIZBOOK_PATH', plugin_dir_path( QUIZBOOK__FILE__ ) );

define( 'QUIZBOOK_URL', plugins_url( '/', QUIZBOOK__FILE__ ) );
define( 'QUIZBOOK_ASSETS_PATH', QUIZBOOK_PATH . 'assets/' );
define( 'QUIZBOOK_ASSETS_URL', QUIZBOOK_PATH . 'assets/' );

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) )  {
    add_action( 'admin_notices', 'quizbook_fail_php_version' );
} else  {
    require QUIZBOOK_PATH . 'plugin.php';
}

/**
 * Quizbook admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.3.0
 *
 * @return void
 */
function quizbook_fail_php_version() {
    /* translators: %s: PHP version */
    $message = sprintf( esc_html__( 'Quizbook requires PHP version %s+, plugin is currently NOT RUNNING.', 'quizbook' ), '5.6' );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}
?>