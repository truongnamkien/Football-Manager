<?php if (isset($streets)): ?>
    <div id="map_table">
        <?php for ($i = 0; $i < Street_model::AREA_HEIGHT; $i++): ?>
            <?php for ($j = 0; $j < Street_model::AREA_WIDTH; $j++): ?>
                <div class="map_cell">
                    <?php if (isset($streets[$j][$i])): ?>
                        <?php if (isset($streets[$j][$i]['level'])): ?>
                            <img src="<?php echo asset_url('images/map/map_cell_npc_' . $streets[$j][$i]['level'] . '.png'); ?>" width="50" height="50" title="<?php echo $streets[$j][$i]['team']['team_name']; ?>" />
                        <?php else: ?>
                            <img src="<?php echo asset_url('images/map/map_cell_user_' . (rand(1, 5)) . '.png'); ?>" width="50" height="50" title="<?php echo $streets[$j][$i]['team']['team_name']; ?>" />
                        <?php endif; ?>

                        <?php
                    else:
                        $x_coor = $col * Street_Model::AREA_WIDTH + $j;
                        $y_coor = $row * Street_Model::AREA_HEIGHT + $i;
                        ?>
                        <img src="<?php echo asset_url('images/map/map_cell_empty_' . (rand(1, 5)) . '.png'); ?>" width="50" height="50" title="<?php echo lang('map_empty_cell'); ?>" />
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
            <div class="clear"></div>
        <?php endfor; ?>
    </div>
<?php endif; ?>
