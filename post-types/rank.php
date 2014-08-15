<?php
/**
 * Created by PhpStorm.
 * User: koeng
 * Date: 8/15/14
 * Time: 1:19 PM
 */

namespace cf_cm_post_types;


class Rank {

    protected $labels;
    protected $args;

    public function __construct(){
        $this->labels = array(
            'name'               => _x( 'Ranks', 'ranks', 'charlie-foxtrot-clan-manager' ),
            'singular_name'      => _x( 'Rank', 'ranks', 'charlie-foxtrot-clan-manager' ),
            'menu_name'          => _x( 'Ranks', 'admin menu', 'charlie-foxtrot-clan-manager' ),
            'name_admin_bar'     => _x( 'Rank', 'add new on admin bar', 'charlie-foxtrot-clan-manager' ),
            'add_new'            => _x( 'Add New', 'ranks', 'charlie-foxtrot-clan-manager' ),
            'add_new_item'       => __( 'Add New Rank', 'charlie-foxtrot-clan-manager' ),
            'new_item'           => __( 'New Rank', 'charlie-foxtrot-clan-manager' ),
            'edit_item'          => __( 'Edit Rank', 'charlie-foxtrot-clan-manager' ),
            'view_item'          => __( 'View Rank', 'charlie-foxtrot-clan-manager' ),
            'all_items'          => __( 'All Ranks', 'charlie-foxtrot-clan-manager' ),
            'search_items'       => __( 'Search Ranks', 'charlie-foxtrot-clan-manager' ),
            'parent_item_colon'  => __( 'Parent Ranks:', 'charlie-foxtrot-clan-manager' ),
            'not_found'          => __( 'No Ranks found.', 'charlie-foxtrot-clan-manager' ),
            'not_found_in_trash' => __( 'No Ranks found in Trash.', 'charlie-foxtrot-clan-manager' )
        );

        $this->args = array(
            'labels'             => $this->labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'rank' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

    }

    public function register(){
        register_post_type( 'cf_cm_rank', $this->args );

    }
} 