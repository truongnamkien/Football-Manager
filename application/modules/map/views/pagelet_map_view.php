<?php if (isset($streets)): ?>
    <table border="1">
        <?php for ($i = 0; $i < Street_model::AREA_HEIGHT; $i++): ?>
            <tr>
                <?php for ($j = 0; $j < Street_model::AREA_WIDTH; $j++): ?>
                    <td>
                        <?php if (isset($streets[$j][$i])): ?>
                            <a href="<?php echo site_url('street/index?street_id=' . $streets[$j][$i]['street_id']) ?>"><?php echo $streets[$j][$i]['street_id']; ?></a>
                        <?php else: ?>
                            <a href="<?php echo site_url('street/empty?x_coor=' . $streets[$j][$i]['x_coor'] . '&y_coor=' . $streets[$j][$i]['y_coor']) ?>"><?php echo $streets[$j][$i]['street_id']; ?></a>
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
<?php endif; ?>
