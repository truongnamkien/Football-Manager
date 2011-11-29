<?php if (isset($streets)): ?>
    <table border="1">
        <?php for ($i = 0; $i < Street_model::AREA_HEIGHT; $i++): ?>
            <tr>
                <?php for ($j = 0; $j < Street_model::AREA_WIDTH; $j++): ?>
                    <td>
                        <?php if (isset($streets[$j][$i])): ?>
                            <a href="<?php echo site_url('street/index?street_id=' . $streets[$j][$i]['street_id']) ?>"><?php echo $streets[$j][$i]['street_id']; ?></a>
                            <?php
                        else:
                            $x_coor = $col * Street_Model::AREA_WIDTH + $j;
                            $y_coor = $row * Street_Model::AREA_HEIGHT + $i;
                            ?>
                            <a href="<?php echo site_url('street/empty?x_coor=' . $x_coor . '&y_coor=' . $y_coor) ?>"><?php echo lang('map_empty_cell'); ?></a>
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
<?php endif; ?>
