<?php
/**
 * Plugin Name: Clan Management
 * Plugin URI: http://charliefoxtrot.org
 * Description: A plugin to manage gaming communities
 * Version: 0.1
 * Author: Tweetdezweet
 * Author URI: http://www.koengabriels.be
 * License: GPL2
 */

defined('ABSPATH') or die("No script kiddies please!");

include_once 'post-type-registration.php';
include_once 'user-profile-extension.php';
include_once 'functions.php';

add_shortcode('test', 'dump_players');

function dump_players(){
    var_dump( cf_cm_get_all_players() );
}