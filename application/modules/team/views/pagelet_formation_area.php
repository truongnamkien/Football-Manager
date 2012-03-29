<?php for ($line = 0; $line < 3; $line++): ?>
    <?php for ($col = 1; $col <= $format['col']; $col++): ?>
        <div class="area<?php echo $format['col']; ?>">
            <?php echo (in_array(($line * $format['col'] + $col), $format['position']) ? Modules::run('team/_pagelet_player_select', $team_id) : ''); ?>
        </div>
    <?php endfor; ?>
<?php endfor; ?>
<div class="clear"></div>