<div id="building_detail_img">
    <img class="not_hover" src="<?php echo asset_url('images/building/' . $image . '.png'); ?>" width="480" />
    <img class="is_hover" src="<?php echo asset_url('images/building/' . $image . '_select.png'); ?>" width="480" />
</div>

<table id="building_detail_info">
    <thead>
        <tr>
            <th><?php echo lang('building_type_name') ?></th>
            <th><?php echo lang('building_type_description') ?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($building_types as $building): ?>
            <tr>
                <td><?php echo $building['name'] ?></td>
                <td><?php echo $building['description'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="clear"></div>