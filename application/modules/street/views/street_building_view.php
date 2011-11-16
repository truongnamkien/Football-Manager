<table>
    <thead>
        <tr>
            <th><?php echo lang('building_type_street_cell') ?></th>
            <th><?php echo lang('building_type_name') ?></th>
            <th><?php echo lang('building_level') ?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>

        <?php if (isset($buildings)): ?>
            <?php foreach ($buildings as $building): ?>
                <tr>
                    <td><?php echo $building['street_cell'] ?></td>
                    <td><?php echo $building['name'] ?></td>
                    <td><?php echo $building['level'] ?></td>
                    <td><a href="#" ajaxify="<?php echo site_url('ajax/street_ajax/upgrade?bs=' . $building['street_building_id'] . '&st=' . $street['street_id']); ?>" rel="async"><?php echo lang('building_upgrade') ?></a></td>
                    <td><a href="#" ajaxify="<?php echo site_url('ajax/street_ajax/downgrade?bs=' . $building['street_building_id'] . '&st=' . $street['street_id']); ?>" rel="async"><?php echo lang('building_downgrade') ?></a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
