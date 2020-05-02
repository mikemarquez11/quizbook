<?php
namespace Quizbook\Results;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
  * The AJAX functionality of the plugin.
  *
  * @link       http://example.com
  * @since      1.3.0
  *
  * @package    Quizbook
  * @subpackage Quizbook/Admin
  */
class Quizbook_Results {

    public function quizbook_results() {

      if ( isset($_POST['data']) ) {
        $answers = $_POST['data'];
      }

      $result = 0;

      foreach($answers as $answer){
          $question = explode(':', $answer);

          /**
           * $question[0] = post_ID
           * $question[1] = user's answer 
           */
          $correct = get_post_meta($question[0], 'quizbook_correct', true);

          /**
           * $correct_letter[0] = qb_correct
           * $answer[1] correct_letter
           */
          $correct_letter = explode(':', $correct);

          if( $correct_letter[1] === $question[1] ) {
            $result += 20;
          }
      }

        $total_quiz = array(
            'total' => $result
        );

        header('Content-type: application/json');
        echo json_encode($total_quiz);
        die();
    }
}