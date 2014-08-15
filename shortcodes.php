<?php
add_shortcode('test', 'dump_players');

function dump_players(){
    var_dump( cf_cm_get_all_players() );
}

require_once __DIR__ . '/helpers/shortcode.php';

$short_code = new \helpers\Shortcode();

add_shortcode('cf_cm_show_roster', array( $short_code, 'show_roster' ) );

