<?php
/**
 * Created by PhpStorm.
 * User: koeng
 * Date: 8/15/14
 * Time: 2:19 PM
 */

namespace user_profiles;


class User_Profile {
    public function show_extra_profile_fields( $user ) { ?>

        <h3>Extra profile information</h3>

        <table class="form-table">

            <tr>
                <th><label for="rank">Rank</label></th>

                <td>
                    <?php
                    $args = array(
                        'post_type' => 'cf_cm_rank',
                        'post_status' => 'publish');
                    $available_ranks = get_posts( $args );
                    $user_rank = get_user_meta($user->ID, 'rank', true);
                    ?>
                    <?php if( ! current_user_can( 'edit_users') ): ?>
                        <?php if( '' == $user_rank): ?>
                            No rank given yet
                        <?php else:?>
                            <?php echo $user_rank ?>
                        <?php endif;?>
                    <?php else: ?>
                    <select name="rank" id="rank">
                        <?php
                            $selected = '' == $user_rank ? 'selected' : '';
                            echo sprintf('<option value="norank" selected="%s">Choose a rank</option>', $selected);
                        ?>

                        <?php foreach($available_ranks as $rank) {
                            $selected = $rank->ID == $user_rank ? 'selected' : '';
                            echo sprintf('<option value="%s" selected="%s" >%s</option>', $rank->ID, $selected, $rank->post_title);
                        } ?>
                    </select>
                    <span class="description">Please enter the rank of the user.</span>
                    <?php endif; ?>
                </td>
            </tr>

        </table>
    <?php
    }

    function save_extra_profile_fields( $user_id ) {
        if ( ! current_user_can( 'edit_users' ) )
            return false;

        update_user_meta( $user_id, 'rank', $_POST['rank']) ;
    }
} 