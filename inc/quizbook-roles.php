<?php

namespace Quizbook\Roles;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The ROles functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.3.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Roles
*/
class Quizbook_Roles {

    public function quizbook_add_role() {
        add_role('quizbook', 'Quizzes');
    }

    public function quizbook_remove_role() {
        remove_role('quizbook', 'Quizzes');
    }

    public function quizbook_add_capabilities() {

        $roles = array( 'administrator', 'editor', 'quizbook' );
    
        foreach( $roles as $the_role ) {
            $role = get_role( $the_role );
            $role->add_cap( 'read' );
            $role->add_cap( 'edit_quizzes' );
            $role->add_cap( 'publish_quizzes' );
            $role->add_cap( 'edit_published_quizzes' );
            $role->add_cap( 'edit_others_quizzes' );
            $role->add_cap( 'delete_others_quizzes' );
    
        }
    
        $manager_roles = array( 'administrator', 'editor' );
    
        foreach( $manager_roles as $the_role ) {
            $role = get_role( $the_role );
            $role->add_cap( 'read_private_quizzes' );
            $role->add_cap( 'edit_others_quizzes' );
            $role->add_cap( 'edit_private_quizzes' );
            $role->add_cap( 'delete_quizzes' );
            $role->add_cap( 'delete_published_quizzes' );
            $role->add_cap( 'delete_private_quizzes' );
            $role->add_cap( 'delete_others_quizzes' );
        }
    
    }

    public function quizbook_remove_capabilities() {

        $manager_roles = array( 'administrator', 'editor' );
    
        foreach( $manager_roles as $the_role ) {
            $role = get_role( $the_role );
            $role->remove_cap( 'read' );
            $role->remove_cap( 'edit_quizzes' );
            $role->remove_cap( 'publish_quizzes' );
            $role->remove_cap( 'edit_published_quizzes' );
            $role->remove_cap( 'read_private_quizzes' );
            $role->remove_cap( 'edit_others_quizzes' );
            $role->remove_cap( 'edit_private_quizzes' );
            $role->remove_cap( 'delete_quizzes' );
            $role->remove_cap( 'delete_published_quizzes' );
            $role->remove_cap( 'delete_private_quizzes' );
            $role->remove_cap( 'delete_others_quizzes' );
        }
    
    }

    /**
    * Add Capabilities Exams
    */
    public function quizbook_exams_add_capabilities() {

        $roles = array( 'administrator', 'editor', 'quizbook' );

        foreach( $roles as $the_role ) {
            $role = get_role( $the_role );
            $role->add_cap( 'read' );
            $role->add_cap( 'edit_exams' );
            $role->add_cap( 'publish_exams' );
            $role->add_cap( 'edit_published_exams' );
            $role->add_cap( 'edit_others_exams' );
        }

    $manager_roles = array( 'administrator', 'editor' );

        foreach( $manager_roles as $the_role ) {
            $role = get_role( $the_role );
            $role->add_cap( 'read_private_exams' );
            $role->add_cap( 'edit_others_exams' );
            $role->add_cap( 'edit_private_exams' );
            $role->add_cap( 'delete_exams' );
            $role->add_cap( 'delete_published_exams' );
            $role->add_cap( 'delete_private_exams' );
            $role->add_cap( 'delete_others_exams' );
        }

    }

    /**
    * Remove Task-level capabilities to Administrator, Editor, and Task Logger.
    */
    function quizbook_exams_remove_capabilities() {

        $manager_roles = array( 'administrator', 'editor' );

        foreach( $manager_roles as $the_role ) {
            $role = get_role( $the_role );
            $role->remove_cap( 'read' );
            $role->remove_cap( 'edit_exams' );
            $role->remove_cap( 'publish_exams' );
            $role->remove_cap( 'edit_published_exams' );
            $role->remove_cap( 'read_private_exams' );
            $role->remove_cap( 'edit_others_exams' );
            $role->remove_cap( 'edit_private_exams' );
            $role->remove_cap( 'delete_exams' );
            $role->remove_cap( 'delete_published_exams' );
            $role->remove_cap( 'delete_private_exams' );
            $role->remove_cap( 'delete_others_exams' );
        }

    }
}
?>