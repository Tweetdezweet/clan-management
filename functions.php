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
        array_push($user_info,
            array(
                'name' => $user->user_login,
                'rank_id' => get_user_meta($user->ID, 'rank')
            )
        );
    }
    return $user_info;
}