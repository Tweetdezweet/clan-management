<div>
    <h1>Roster</h1>
    <?php foreach(cf_cm_get_all_players() as $player): ?>
        <?php $rank = get_post($player->rank_id); ?>
    <div class="player">
        <div class="player-name"><?php echo $player->name ?></div>
        <div class="player-rank"><?php echo $rank->post_title ?></div>
    </div>
    <?php endforeach; ?>
</div>