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
                    <td><?php echo lang('building_upgrade') ?></td>
                    <td><?php echo lang('building_downgrade') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
