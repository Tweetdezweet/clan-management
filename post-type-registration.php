<?php

require_once __DIR__ . '/post-types/rank.php';

$rank = new \cf_cm_post_types\Rank();
add_action('init', array($rank, 'register'));

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