<?php

namespace Quizbook\Form_Quizzes;

use Quizbook\Utils\Quizbook_Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The Form_Quizzes functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Form_Quizzes
*/
class Quizbook_Form_Quizzes {

    protected $qb_utils;

/**
 * Form Constructor.
 *
 * Initializing Quizbook plugin.
 *
 * @since 1.0.0
 * @access private
 */
    public function __construct() {
        $this->includes_form();
        $this->define_form_hooks();
    }

    public function includes_form() {
        require_once QUIZBOOK_PATH . 'inc/quizbook-utils.php';
    }

    public function define_form_hooks() {
        $this->qb_utils = new Quizbook_Utils();
    }

    public function render_form_quizzes($atts) {

        $args = array(
            'post_type' => 'quizzes',
            'posts_per_page' => $atts['questions'],
            'orderby' => $atts['order']
        );

        //$qb_utils = new Quizbook_Utils();
        $quizbook = new \WP_Query($args);
    ?>
    <form action="" name="quizbook_send" id="quizbook_send">
        <div id="quizbook" class="quizbook">
        <ul>
        <?php while($quizbook->have_posts()): $quizbook->the_post(); ?>
        <li>
            <?php the_title('<h2>', '</h2>');
            the_content();
            $qb_options = get_post_meta(get_the_ID(), '');
            foreach($qb_options as $key => $option){
                $result = $this->qb_utils->quizbook_filter_questions($key);

                if($result === 0) { 
                    $number = explode('_', $key); ?>
                    <div id="<?php echo get_the_ID() . ":" . $number[2]; ?>" class="answer">
                        <?php echo $option[0]; ?>
                    </div>
                <?php }
            } ?>
        </li>
            <?php endwhile; 
            wp_reset_postdata(); ?>
        </ul>
        </div>
        <input type="submit" value="Send" id="qb_btn_submit">
        <div class="" id="qb_response_result"></div>
    </form>
    <?php }
}