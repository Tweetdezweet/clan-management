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

    public function add_meta_boxes(){
        add_meta_box(
            'cf_cm_rank_order',
            esc_html__('Rank order', 'charlie-foxtrot-clan-manager'),
            array($this, 'display_rank_order_meta_box'),
            'cf_cm_rank',
            'side',
            'default'
        );
    }

    public function display_rank_order_meta_box(){ ?>
        <?php wp_nonce_field (basename( __FILE__), 'cf_cm_rank_order_nonce' ); ?>

        <p>
            <?php _e('Add rank ', 'charlie-foxtrot-clan-manager') ?>
            <?php
                global $post;
                $args = array(
                    'post_type' => 'cf_cm_rank',
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_key' => 'cf_cm_rank_order',
                );
                $other_ranks = get_posts($args);
                $current_rank_order = (int) get_post_meta($post->ID, 'cf_cm_rank_order', true);
                $current_other_rank = $this->get_relative_position($current_rank_order);
            ?>
            <?php if(  $current_other_rank ): ?>
            <select name="position">
                <option value="before" <?php if($current_other_rank['position'] == 'before') echo 'selected="selected"' ?>">before</option>
                <option value="after" <?php if($current_other_rank['position'] == 'after') echo 'selected="selected"' ?>" >after</option>
            </select>

            <select name="other_rank">
                <?php foreach($other_ranks as $other_rank): ?>
                    <option value="<?php echo $other_rank->ID ?>" <?php if( $post->ID == $other_rank->ID ) echo 'disabled' ?> <?php if($current_other_rank['other_rank'] == $other_rank->ID) echo 'selected="selected"' ?> ><?php echo $other_rank->post_title ?></option>
                <?php endforeach; ?>
            </select>
            <?php else:?>
                <div><?php _e('Issue in DB, contact site administrator') ?></div>
            <?php endif;?>
        </p>
    <?php }

    protected function get_relative_position($rank_order){
        $args = array(
            'post_type' => 'cf_cm_rank',
            'post_status' => 'publish',
            'meta_value' => $rank_order - 1,
            'meta_key' => 'cf_cm_rank_order',
        );
        $ranks = get_posts($args);

        if( sizeof($ranks) > 0 ) {
            return array(
                'position' => 'after',
                'other_rank' => $ranks[0]->ID
            );
        } else {
            $args['meta_value'] = $rank_order + 1;
            $ranks = get_posts($args);

            if(sizeof($ranks) > 0 ) {
                return array(
                    'position' => 'before',
                    'other_rank' => $ranks[0]->ID);
            } else {
                return false;
            }
        }
    }

    public function save_post_meta($post_id, $post){
        /* Get the posted data and sanitize it for use as an HTML class. */
        $new_meta_value = ( isset( $_POST['smashing-post-class'] ) ? sanitize_html_class( $_POST['smashing-post-class'] ) : '' );

        /* Get the meta key. */
        $meta_key = 'smashing_post_class';

        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        /* If a new meta value was added and there was no previous value, add it. */
        if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );

        /* If the new meta value does not match the old value, update it. */
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );

        /* If there is no new meta value but an old value exists, delete it. */
        elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
    }

    protected function update_rank_order($rank_id, $relative_position = array() ){
        $other_rank_order = get_post_meta( $relative_position['other_rank'], 'cf_cm_rank_order', true );

        if( 'before' == $relative_position['position'] ) {
            if($other_rank_order == 1) {
                $args = array(
                    'post_type' => 'cf_cm_rank',
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_key' => 'cf_cm_rank_order',
                );
                $ranks = get_posts($args);

                foreach($ranks as $rank) {
                    if( $rank->ID != $rank_id ) {
                        $old_value = get_post_meta( $rank->ID, 'cf_cm_rank_order', true);
                        update_post_meta( $rank->ID, 'cf_cm_rank_order', $old_value + 1);
                    }
                }

                update_post_meta( $rank_id, 'cf_cm_rank_order', 0);

            } else {
                $args = array(
                    'post_type' => 'cf_cm_rank',
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_key' => 'cf_cm_rank_order',
                );
                $ranks = get_posts($args);

                foreach($ranks as $rank) {
                    $old_value = get_post_meta( $rank->ID, 'cf_cm_rank_order', true);

                    if( $rank->ID != $rank_id  && $old_value >= $other_rank_order ) {
                        update_post_meta( $rank->ID, 'cf_cm_rank_order', $old_value + 1);
                    }
                }

                update_post_meta( $rank_id, 'cf_cm_rank_order', $other_rank_order);
            }
        } elseif( 'after' == $relative_position['position']) {
            $args = array(
                'post_type' => 'cf_cm_rank',
                'post_status' => 'publish',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => 'cf_cm_rank_order',
            );
            $ranks = get_posts($args);

            foreach($ranks as $rank) {
                $old_value = get_post_meta( $rank->ID, 'cf_cm_rank_order', true);

                if( $rank->ID != $rank_id  && $old_value >= $other_rank_order ) {
                    update_post_meta( $rank->ID, 'cf_cm_rank_order', $old_value + 1);
                }
            }

            update_post_meta( $rank_id, 'cf_cm_rank_order', $other_rank_order + 1);

        } else {
            return false;
        }
    }
} 