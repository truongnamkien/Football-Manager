<select name="<?php echo $name; ?>">
    <?php foreach ($player_list as $player): ?>
        <option value="<?php echo $player['player_id']; ?>"><?php echo $player['player_id']; ?></option>
    <?php endforeach; ?>
</select>
