<?php
/**
 * Created by PhpStorm.
 * User: koeng
 * Date: 8/15/14
 * Time: 5:26 PM
 */

namespace helpers;


class Shortcode {

    public function show_roster(){
        if( file_exists( get_stylesheet_directory() . '/clan-management/views/frontend/roster_shortcode.php' ) ) {
            $output = include_once get_stylesheet_directory() . '/clan-management/views/frontend/roster_shortcode.php';
        } else {
            $output = include_once __DIR__ . '/../views/frontend/roster_shortcode.php';
        }
        echo $output;
    }
}