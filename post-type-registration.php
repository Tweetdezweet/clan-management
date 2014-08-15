<?php

require_once __DIR__ . '/post-types/rank.php';

$rank = new \cf_cm_post_types\Rank();
add_action('init', array($rank, 'register'));