<div id="user_info">
    <p>
        <span class="fwb fs14"><?php echo (lang('user_display_name') . ': '); ?></span>
        <?php echo $user_info['display_name']; ?>
    </p>
    <p>
        <span class="fwb fs14"><?php echo (lang('user_coordinate') . ': '); ?></span>
        <?php echo ($street_info['x_coor'] . ':' . $street_info['y_coor']); ?>
    </p>
    <p>
        <span class="fwb fs14"><?php echo (lang('user_team') . ': '); ?></span>
        <?php echo $team_info['team_name']; ?>
    </p>
    <p>
        <span class="fwb fs14"><?php echo (lang('user_balance') . ': '); ?></span>
        <span id="user_balance"><?php echo $user_info['balance']; ?></span>
    </p>
</div>

<div id="cooldown_info" class="<?php echo (empty($building_cooldowns) ? 'dpn' : ''); ?>">
    <p class="fwb fs14"><?php echo lang('building_cooldown'); ?></p>
    <ul id="cooldown_list"></ul>
</div>

<script type="text/javascript">
    (function() {
<?php foreach ($building_cooldowns as $cd): ?>
            Cooldown.init(<?php echo $cd['end_time']; ?>, <?php echo $cd['cooldown_id']; ?>);
<?php endforeach; ?>
    }).deferUntil(function() {
        return document.getElementById('cooldown_list');
    });
</script>

