<?php

require_once __DIR__ . '/post-types/rank.php';

$rank = new \cf_cm_post_types\Rank();
add_action('init', array($rank, 'register'));

add_action('load-post.php', 'cf_cm_setup_meta_boxes'  );
add_action('load-post-new.php', 'cf_cm_setup_meta_boxes' );
add_action('save_post', 'cf_cm_save_post_meta');

function cf_cm_setup_meta_boxes() {
    $rank = new \cf_cm_post_types\Rank();
    add_action('add_meta_boxes', array( $rank, 'add_meta_boxes') );
}

function cf_cm_save_post_meta($post_id, $post){
    /* Save the meta box's post metadata. */

        /* Verify the nonce before proceeding. */
        if ( !isset( $_POST['smashing_post_class_nonce'] ) || !wp_verify_nonce( $_POST['smashing_post_class_nonce'], basename( __FILE__ ) ) )
            return $post_id;

        /* Get the post type object. */
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;


        if( 'cf_cm_rank' ==  $post_type ) {
            $rank = new \cf_cm_post_types\Rank();
            $rank->save_post_meta($post_id, $post);
        }
}

function cf_cm_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    $rank = new \cf_cm_post_types\Rank();
    $rank->register();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cf_cm_rewrite_flush' );