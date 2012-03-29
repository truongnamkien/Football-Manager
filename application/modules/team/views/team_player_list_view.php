<div class="content-box">
    <div class="content-box-header">
        <h3><?php echo lang('team_player') ?></h3>
    </div>

    <div class="content-box-content">
        <div class="tab-content default-tab" style="display: block;">
            <?php if (!empty($player_list)) : ?>
                <table id="player_list">
                    <thead>
                        <tr>
                            <th><?php echo lang('player_display_name'); ?></th>
                            <th><?php echo lang('player_position'); ?></th>
                            <th><?php echo lang('player_strenth'); ?></th>
                            <th><?php echo lang('player_condition'); ?></th>
                            <th><?php echo lang('player_manner'); ?></th>
                            <th><?php echo lang('player_physical'); ?></th>
                            <th><?php echo lang('player_flexibility'); ?></th>
                            <th><?php echo lang('player_goalkeeper'); ?></th>
                            <th><?php echo lang('player_defence'); ?></th>
                            <th><?php echo lang('player_shooting'); ?></th>
                            <th><?php echo lang('player_passing'); ?></th>
                            <th><?php echo lang('player_thwart'); ?></th>
                            <th><?php echo lang('player_speed'); ?></th>
                        </tr>
                    </thead>

                    <tbody>                       
                        <?php foreach ($player_list as $position): ?>
                            <?php foreach ($position as $player): ?>
                                <tr>
                                    <td><?php echo $player['last_name'] . ' ' . $player['middle_name'] . ' ' . $player['first_name']; ?></td>
                                    <td><?php echo lang('formation_' . $player['position']); ?></td>
                                    <td><?php echo $player['strength']; ?></td>
                                    <td><?php echo $player['condition']; ?></td>
                                    <td><?php echo $player['manner']; ?></td>
                                    <td><?php echo $player['physical']; ?></td>
                                    <td><?php echo $player['flexibility']; ?></td>
                                    <td><?php echo $player['goalkeeper']; ?></td>
                                    <td><?php echo $player['defence']; ?></td>
                                    <td><?php echo $player['shooting']; ?></td>
                                    <td><?php echo $player['passing']; ?></td>
                                    <td><?php echo $player['thwart']; ?></td>
                                    <td><?php echo $player['speed']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
