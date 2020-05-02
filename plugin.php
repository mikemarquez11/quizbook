<?php
namespace Quizbook;

use Quizbook\Admin\Quizbook_Admin;
use Quizbook\Metaboxes\Quizbook_Metaboxes;
use Quizbook\Roles\Quizbook_Roles;
use Quizbook\Shortcode\Quizbook_Shortcode;
use Quizbook\Results\Quizbook_Results;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Lovetura Contact plugin.
 *
 * The main plugin handler class is responsible for initializing LoveturaContact. The
 * class registers and all the components required to run the plugin.
 * @since 1.0.0
 */
class Quizbook {

/**
 * The unique identifier of this plugin
 *
 * @since 1.0.0
 * @access protected
 * @var string $Quizbook The string used to uniquely identify this plugin.
 */
protected $Quizbook;

/**
 * The current version of the plugin
 *
 * @since 1.0.0
 * @access protected
 * @var string $version The current version of this plugin.
 */
protected $version;

/**
 * Instance.
 * 
 * Holds the plugin QB instance.
 * 
 * @since 1.0.0
 * @access public
 * @static
 */
public static $instance = null;

/**
 * Instance.
 * 
 * Ensures only one instance of the plugin class is loaded or can be loaded.
 *
 * @since 1.0.0
 * @access public
 * @static
 *
 * @return Plugin an Instance of the class 
 */
public static function instance() {
    if ( is_null( self::$instance ) ) {
        self::$instance = new self();
    }

    return self::$instance;
}

/**
 * The name of the plugin used to uniquely identify it within the context of
 * Wordpress and to define internationalization functionality.
 *
 * @since 1.0.0
 * @return string The name of the plugin.
 */
public function get_Quizbook() {
    return $this->Quizbook;
}

/**
 * Retrieve the version number of the plugin
 * 
 * @since 1.0.0
 * @return string The version number of the plugin.
 * 
 */
public function get_version() {
    return $this->version;
}

/**
 * Plugin Constructor.
 *
 * Initializing Quizbook plugin.
 *
 * @since 1.0.0
 * @access private
 */
private function __construct() {

    $this->Quizbook = 'Quizbook';
    $this->version = '1.0.0';

    $this->includes();
    $this->load_textdomain();
    $this->define_quizbook_hooks();

    add_action( 'admin_enqueue_scripts', [ $this, 'quizbook_admin_styles'] );
    add_action( 'admin_enqueue_scripts', [ $this, 'quizbook_admin_scripts' ]);
    add_action( 'wp_enqueue_scripts', [ $this, 'quizbook_styles'] );
    add_action( 'wp_enqueue_scripts', [ $this, 'quizbook_scripts' ] );
}

/**
 * Loads the globally required Files for the Plugin.
 * 
 * Includes validation
 * 
 * @since 1.0.1
 * @access private
 */
public function includes() {
    require_once QUIZBOOK_PATH . 'admin/quizbook-admin.php';
    require_once QUIZBOOK_PATH . 'inc/quizbook-metaboxes.php';
    require_once QUIZBOOK_PATH . 'inc/quizbook-roles.php';
    require_once QUIZBOOK_PATH . 'inc/quizbook-shortcode.php';
    require_once QUIZBOOK_PATH . 'inc/quizbook-results.php';
}

/**
 * Register all of the hooks related to the functionality
 * of the plugin
 *
 * @since 1.0.1
 * @access public
 */
private function define_quizbook_hooks() {
    $quizbook_admin = new Quizbook_Admin();
    $quizbook_meta = new Quizbook_Metaboxes();
    $qb_roles = new Quizbook_Roles();
    $qb_sc = new Quizbook_Shortcode();
    $qb_results = new Quizbook_Results();

    add_action( 'init', [ $quizbook_admin, 'custom_post_quizzes'] );
    add_action( 'init', [ $quizbook_admin, 'custom_post_exams'] );
    // Columns Exams Post Type
    add_filter( 'manage_exams_posts_columns', [ $quizbook_admin, 'quizbook_exam_new_column' ] );
    add_action( 'manage_exams_posts_custom_column', [ $quizbook_admin, 'quizbook_exam_shortcode_column' ], 5, 1);
    register_activation_hook( QUIZBOOK__FILE__, [ $quizbook_admin, 'quizbook_rewrite_flush' ] );
    register_activation_hook( QUIZBOOK__FILE__, [ $quizbook_admin, 'quizbook_exams_rewrite_flush' ] );
    // Add Roles to Quizzes
    register_activation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_add_role' ] );
    register_deactivation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_remove_role' ] );
    // Add Capabilities to Quizzes
    register_activation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_add_capabilities' ] );
    register_deactivation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_remove_capabilities' ] );
     // Add Capabilities to Exams
    register_activation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_exams_add_capabilities' ] );
    register_deactivation_hook( QUIZBOOK__FILE__, [ $qb_roles, 'quizbook_exams_remove_capabilities' ] );
    // Add Metaboxes
    add_action( 'add_meta_boxes', [ $quizbook_meta, 'quizbook_add_metaboxes' ] );
    add_action( 'save_post', [ $quizbook_meta, 'quizbook_save_metaboxes' ], 10, 3 );
    // Add Metaboxes to Exams
    add_action( 'add_meta_boxes', [ $quizbook_meta, 'quizbook_exam_add_metaboxes' ] );
    add_action( 'save_post', [ $quizbook_meta, 'quizbook_save_exam_metaboxes' ], 10, 3 );
    // Add Shortcode QUizzes
    add_shortcode( 'quizbook', [ $qb_sc, 'quizbook_shortcode' ] );
    // Add Shortcode Exams
    add_shortcode('quizbook-exam', [ $qb_sc, 'quizbook_exam_shortcode' ]);
        
    add_action( 'wp_ajax_quizbook_results', [ $qb_results, 'quizbook_results' ] );
    add_action( 'wp_ajax_nopriv_quizbook_results', [ $qb_results, 'quizbook_results' ] );

    //add_action( 'wp_ajax_send_email', [ $lovec_sub, 'sendLoveturaEmail' ] );
    //add_action( 'wp_ajax_nopriv_send_email', [ $lovec_sub, 'sendLoveturaEmail' ] );
}

/**
 * Loads textdomain for the Plugin
 *
 * @since 1.3.0
 * @access public
 */
public function load_textdomain() {
    load_plugin_textdomain( 'quizbook' );
}
 
public function quizbook_styles() {
    // Quizbook Styles
    wp_register_style( 'quizbook-custom', plugins_url('assets/css/quizbook.css', __FILE__), array(), QUIZBOOK_VERSION );
 
    // Enqueue Styles
    wp_enqueue_style( 'quizbook-custom' );
}

public function quizbook_scripts() {
    // Quizbook Scripts
    wp_register_script( 'quizbook-custom', plugins_url('assets/js/quizbook.js', __FILE__), array( 'jquery' ), QUIZBOOK_VERSION, true );

    wp_localize_script(
        'quizbook-custom',
        'admin_url',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );

    // Enqueue Scripts
    wp_enqueue_script('quizbook-custom');
}

public function quizbook_admin_styles($hook) {
    global $post;

    // Admin Styles
    wp_register_style( 'quizbook-styles-admin', plugins_url('assets/css/quizbook-admin.css', __FILE__), array(), QUIZBOOK_VERSION);

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if($post->post_type === 'quizzes' || $post->post_type === 'exams' ) {
            // Enqueue Styles
            wp_enqueue_style( 'quizbook-styles-admin' );
        }
    }
}

public function quizbook_admin_scripts($hook) {
    global $post;

    // Chosen Styles
    wp_register_style( 'quizbook-chosen-admin', plugins_url('assets/css/chosen.min.css', __FILE__), array(), QUIZBOOK_VERSION);
    // Chosen jQuery
    wp_register_script( 'quizbook-chosen', plugins_url('assets/js/chosen.jquery.min.js', __FILE__), array( 'jquery' ), QUIZBOOK_VERSION, true );
    // Quizbook Scripts
    wp_register_script( 'quizbook-scripts', plugins_url('assets/js/quizbook-scripts.js', __FILE__), array( 'jquery' ), QUIZBOOK_VERSION, true );

    if($hook == 'post-new.php' || $hook == 'post.php') {
        if('exams' === $post->post_type) {
            // Enqueue Scripts
            wp_enqueue_style( 'quizbook-chosen-admin' );
            wp_enqueue_script('quizbook-chosen');
            wp_enqueue_script('quizbook-scripts');
        }
    }
}

}
// Instantiate Plugin Class
Quizbook::instance();
?>