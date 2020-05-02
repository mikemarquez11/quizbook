<?php

namespace Quizbook\Shortcode;

use Quizbook\Form_Quizzes\Quizbook_Form_Quizzes;
use Quizbook\Form_Exams\Quizbook_Form_Exams;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The shortcode functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Shortcode
*/
class Quizbook_Shortcode {

    protected $quizzes_form;

    public function quizbook_shortcode($atts){
        ob_start();
        $this->quizbook_view($atts);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function quizbook_view($atts) { 
        require_once( QUIZBOOK_PATH . 'views/quizbook-form-quizzes.php' );

        $this->quizzes_form = new Quizbook_Form_Quizzes();
        $this->quizzes_form->render_form_quizzes($atts);
    }

    public function quizbook_exam_shortcode($atts){
        ob_start();
        $this->quizbook_exam($atts);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    

    public function quizbook_exam($atts) {
        require_once( QUIZBOOK_PATH . 'views/quizbook-form-exam.php' );

        $this->quizzes_form = new Quizbook_Form_Exams();
        $this->quizzes_form->render_form_exam($atts);
    }
}
?>