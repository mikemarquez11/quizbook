<?php

namespace Quizbook\Metaboxes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The metaboxes functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.3.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Metaboxes
*/
class Quizbook_Metaboxes {

    public function quizbook_add_metaboxes() {
        // Add the metabox to quizzes
        add_meta_box(
            'quizbook_meta_box',
            'Answers',
            [$this, 'quizbook_metaboxes'],
            'quizzes',
            'normal',
            'high',
            null
        );
    }

    /**
     * Show the HTML
     */
    public function quizbook_metaboxes($post) {
        wp_nonce_field(basename(__FILE__), 'quizbook_nonce');
    ?>
        <table class="form-table">
            <tr>
                <th class="row-title">
                <h2>Add Answers Here<re</h2>
                </th>
            </tr>
            <tr>
                <th class="row-title">
                    <label for="answer-a">a)</label>
                </th>
                <td>
                    <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_answer_a', true)); ?>" type="text" id="answer-a" name="qb_answer_a" class="regular-text">
                </td>
            </tr>

            <tr>
                <th class="row-title">
                    <label for="answer-b">b)</label>
                </th>
                <td>
                    <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_answer_b', true)); ?>" type="text" id="answer-b" name="qb_answer_b" class="regular-text">
                </td>
            </tr>

            <tr>
                <th class="row-title">
                    <label for="answer-c">c)</label>
                </th>
                <td>
                    <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_answer_c', true)); ?>" type="text" id="answer-c" name="qb_answer_c" class="regular-text">
                </td>
            </tr>

            <tr>
                <th class="row-title">
                    <label for="answer-d">d)</label>
                </th>
                <td>
                    <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_answer_d', true)); ?>" type="text" id="answer-d" name="qb_answer_d" class="regular-text">
                </td>
            </tr>

            <tr>
                <th class="row-title">
                    <label for="answer-e">e)</label>
                </th>
                <td>
                    <input value="<?php echo esc_attr(get_post_meta($post->ID, 'qb_answer_e', true)); ?>" type="text" id="answer-e" name="qb_answer_e" class="regular-text">
                </td>
            </tr>

            <tr>
                <th class="row-title">
                    <label for="answer-correct">Correct Answer</label>
                </th>
                <td>
                <?php $answer = esc_html(get_post_meta($post->ID, 'quizbook_correct', true)); ?>
                    <select name="quizbook_correct" id="answer-correct" class="postbox">
                        <option value="" disabled>Choose the Correct Answer</option>
                        <option <?php selected($answer, 'qb_correct:a'); ?> value="qb_correct:a">a</option>
                        <option <?php selected($answer, 'qb_correct:b'); ?> value="qb_correct:b">b</option>
                        <option <?php selected($answer, 'qb_correct:c'); ?> value="qb_correct:c">c</option>
                        <option <?php selected($answer, 'qb_correct:d'); ?> value="qb_correct:d">d</option>
                        <option <?php selected($answer, 'qb_correct:e'); ?> value="qb_correct:e">e</option>
                    </select>
                </td>
            </tr>

        </table>
    <?php
    }

    public function quizbook_save_metaboxes($post_ID, $post, $update) {
        if(!isset($_POST['quizbook_nonce']) || !wp_verify_nonce($_POST['quizbook_nonce'], basename(__FILE__))) {
            return $post_ID;
        }

        if(!current_user_can('edit_post', $post_ID)){
            return $post_ID;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return $post_ID;
        }

        $answer_1 = $answer_2 = $answer_3 = $answer_4 = $answer_5 = $correct = '';
        
        if (isset( $_POST['qb_answer_a'] )) {
            $answer_1 = sanitize_text_field( $_POST['qb_answer_a'] );
        }

        update_post_meta($post_ID, 'qb_answer_a', $answer_1);

        if (isset( $_POST['qb_answer_b'] )) {
            $answer_2 = sanitize_text_field( $_POST['qb_answer_b'] );
        }

        update_post_meta($post_ID, 'qb_answer_b', $answer_2);

        if (isset( $_POST['qb_answer_c'] )) {
            $answer_3 = sanitize_text_field( $_POST['qb_answer_c'] );
        }

        update_post_meta($post_ID, 'qb_answer_c', $answer_3);

        if (isset( $_POST['qb_answer_d'] )) {
            $answer_4 = sanitize_text_field( $_POST['qb_answer_d'] );
        }

        update_post_meta($post_ID, 'qb_answer_d', $answer_4);

        if (isset( $_POST['qb_answer_e'] )) {
            $answer_5 = sanitize_text_field( $_POST['qb_answer_e'] );
        }

        update_post_meta($post_ID, 'qb_answer_e', $answer_5);

        if (isset( $_POST['quizbook_correct'] )) {
            $correct = sanitize_text_field( $_POST['quizbook_correct'] );
        }

        update_post_meta($post_ID, 'quizbook_correct', $correct);
    }


    public function quizbook_exam_add_metaboxes() {
        // Add the metabox to quizzes
        add_meta_box(
            'quizbook_exam_meta_box',
            'Exam Questions',
            [$this, 'quizbook_exam_metaboxes'],
            'exams',
            'normal',
            'high',
            null
        );
    }

    public function quizbook_exam_metaboxes($post) { 
        wp_nonce_field(basename(__FILE__), 'quizbook_exam_nonce'); ?>
        <table class="form-table">
            <tr>
                <th class="row-title" colspan="2"></th>
                <h2>Selecciona las respuestas para que se incluyan en este examen</h2>
            </tr>
            <tr>
                <th class="row-title"><label for="">Selecciona de la Lista</label></th>
                <td>
                    <?php
                    $args = array(
                        'post_type' => 'quizzes',
                        'posts_per_page' => -1,        
                    ); 

                    $questions = get_posts($args);
                    
                    if ( $questions ) { 
                        $q_selected = maybe_unserialize(get_post_meta($post->ID, 'quizbook_exam', true)); ?>

                        <select data-placeholder="Choose Answers..." class="questions-select" multiple tabindex="4" name="quizbook_exam[]">
                            <option value=""></option>
                            <?php foreach($questions as $question) { 
                                if ($q_selected) { ?>
                                    <option <?php echo in_array( $question->ID, $q_selected ) ? 'selected' : ''; ?> value="<?php echo $question->ID; ?>"><?php echo $question->post_title; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $question->ID; ?>"><?php echo $question->post_title; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    <?php } else {
                        echo '<p>Comienza por agregar preguntas en quizzes</p>';
                    }

                    ?> 
                </td>
            </tr>
        </table>
    <?php
    }

    public function quizbook_save_exam_metaboxes($post_ID, $post, $update) {
        if(!isset($_POST['quizbook_exam_nonce']) || !wp_verify_nonce($_POST['quizbook_exam_nonce'], basename(__FILE__))) {
            return $post_ID;
        }

        if(!current_user_can('edit_post', $post_ID)){
            return $post_ID;
        }

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return $post_ID;
        }

        $answers = '';
        $array_answers = array();

        if ( isset($_POST['quizbook_exam']) ) {
            $answers = $_POST['quizbook_exam'];
        }

        foreach($answers as $answer) {
            $array_answers[] = sanitize_text_field($answer);
        }

        update_post_meta($post_ID, 'quizbook_exam', maybe_serialize( $array_answers ) );
    }
}

?>