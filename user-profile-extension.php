<?php
require_once __DIR__ . '/user-profiles/user-profile.php';

$user_profile = new \user_profiles\User_Profile();
add_action( 'edit_user_profile', array($user_profile, 'show_extra_profile_fields' ) );
add_action( 'show_user_profile', array( $user_profile, 'show_extra_profile_fields' ) );

add_action( 'edit_user_profile_update', array( $user_profile, 'save_extra_profile_fields' ) );
add_action( 'personal_options_update', array( $user_profile, 'save_extra_profile_fields' ) );