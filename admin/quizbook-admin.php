<?php
namespace Quizbook\Admin;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
  * The admin-specific functionality of the plugin.
  *
  * @link       http://example.com
  * @since      1.3.0
  *
  * @package    Quizbook
  * @subpackage Quizbook/Admin
  */
class Quizbook_Admin {

  public function custom_post_quizzes() {

    $labels = array(
      'name'                  => _x( 'Quizzes', 'Post type general name', 'quizbook' ),
      'singular_name'         => _x( 'Quiz', 'Post type singular name', 'quizbook' ),
      'menu_name'             => _x( 'Quizzes', 'Admin Menu text', 'quizbook' ),
      'name_admin_bar'        => _x( 'Quiz', 'Add New on Toolbar', 'quizbook' ),
      'add_new'               => __( 'Add New', 'quizbook' ),
      'add_new_item'          => __( 'Add New Quiz', 'quizbook' ),
      'new_item'              => __( 'New Quiz', 'quizbook' ),
      'edit_item'             => __( 'Edit Quiz', 'quizbook' ),
      'view_item'             => __( 'View Quiz', 'quizbook' ),
      'all_items'             => __( 'All Quizzes', 'quizbook' ),
      'search_items'          => __( 'Search Quiz', 'quizbook' ),
      'parent_item_colon'     => __( 'Parent Quiz', 'quizbook' ),
      'not_found'             => __( 'Not Found', 'quizbook' ),
      'not_found_in_trash'    => __( 'Not Found in Trash', 'quizbook' ),
      'featured_image'        => _x( 'Featured Image', '', 'quizbook' ),
      'set_featured_image'    => _x( 'Add Featured Image', '', 'quizbook' ),
      'remove_featured_image' => _x( 'Delete Featured Image', '', 'quizbook' ),
      'use_featured_image'    => _x( 'Use as Featured Image', '', 'quizbook' ),
      'archives'              => _x( 'Quizzes Archive', '', 'quizbook' ),
      'insert_into_item'      => _x( 'Insert in Quiz', '', 'quizbook' ),
      'uploaded_to_this_item' => _x( 'Uploaded to this Quiz', '', 'quizbook' ),
      'filter_items_list'     => _x( 'Filter Quizzes List', '”. Added in 4.4', 'quizbook' ),
      'items_list_navigation' => _x( 'Quizzes Navigation', '', 'quizbook' ),
      'items_list'            => _x( 'Quizzes List', '', 'quizbook' ),
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'quizzes' ),
    'capability_type'    => array('quiz', 'quizzes'),
    'menu_position'      => 6,
    'menu_icon'          => 'dashicons-welcome-learn-more',
    'has_archive'        => true,
    'hierarchical'       => false,
    'supports'           => array( 'title', 'editor'),
    'map_meta_cap'       => true,
  );

    register_post_type( 'quizzes', $args );
  }

  /**
   * Flush Rewrite
   */
  public function quizbook_rewrite_flush() {
    $this->custom_post_quizzes();
    flush_rewrite_rules();
  }

  public function custom_post_exams() {

    $labels = array(
      'name'               => _x( 'Exams', 'post type general name', '' ),
      'singular_name'      => _x( 'Exams', 'post type singular name', '' ),
      'menu_name'          => _x( 'Exams', 'admin menu', '' ),
      'name_admin_bar'     => _x( 'Exam', 'add new on admin bar', '' ),
      'add_new'            => _x( 'Add New', 'book', '' ),
      'add_new_item'       => __( 'Add New Exam', '' ),
      'new_item'           => __( 'New Exam', '' ),
      'edit_item'          => __( 'Edit Exam', '' ),
      'view_item'          => __( 'View Exam', '' ),
      'all_items'          => __( 'All Exams', '' ),
      'search_items'       => __( 'Search Exam', '' ),
      'parent_item_colon'  => __( 'Parent Exam:', '' ),
      'not_found'          => __( 'Not Found', '' ),
      'not_found_in_trash' => __( 'Not Found in Trash', '' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Add functionality to quizzes', '' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'exams' ),
      'capability_type'    => array('exam', 'exams'),
      'menu_position'      => 7,
      'menu_icon'          => 'dashicons-welcome-write-blog',
      'has_archive'        => true,
      'hierarchical'       => false,
      'supports'           => array( 'title' ),
      'map_meta_cap'       => true,
    );
  
    register_post_type( 'exams', $args );
  }

/**
 * Flush rewrite rules on activation.
 * @since      1.0.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Admin
 */
  public function quizbook_exams_rewrite_flush() {
	  $this->custom_post_exams();
	  flush_rewrite_rules();
  }

  /**
   * Add Column to Exams Posts
   * 
   * @since      1.0.0
   * @package    Quizbook
   * @subpackage Quizbook/Admin  
   */
  public function quizbook_exam_new_column($defaults) {
    $defaults['shortcode'] = __( 'Shortcode', 'bookquiz' );

    return $defaults;
  }

  /**
   * 'Shortcode' Column
   * Show Value
   * 
   * @since 1.0.0
   * @package Quizbook
   * @subpackage Quizbook/Admin 
   */
  public function quizbook_exam_shortcode_column( $column ) {
    if ( $column === 'shortcode' ) {
      $examen_id = get_the_ID();
      echo "[quizbook-exam questions='3' order='rand' id='$examen_id']";
    }
  }
}
?>