<?php

namespace Quizbook\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The utils functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.3.0
 *
 * @package    Quizbook
 * @subpackage Quizbook/Utils
*/
class Quizbook_Utils {

    public function quizbook_filter_questions($key) {
        return strpos($key, 'qb_');
    }
}