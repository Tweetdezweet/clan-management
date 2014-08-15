<?php

function cf_cm_get_all_players() {
    $args = array(
        'meta_key' => 'rank',
        'meta_value' => '',
        'meta_compare' => '!=',
    );

    $users = get_users($args);

    $user_info = array();

    foreach($users as $user){
        $user_object = new stdClass();
        $user_object->name = $user->user_login;
        $user_object->rank_id = get_user_meta($user->ID, 'rank', true);
        array_push($user_info, $user_object);
    }
    return $user_info;
}