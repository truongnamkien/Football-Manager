<p>Tài khoản: <span id="my_balance"><?php echo $balance; ?></span></p>
<p>Thời gian chờ:</p>
<ul id="cooldown_list">
</ul>

<div class="clear"></div>

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
                <tr id="street_building_<?php echo $building['street_building_id']; ?>">
                    <td><?php echo $building['street_cell'] ?></td>
                    <td><?php echo $building['name'] ?></td>
                    <td class="building_level"><?php echo $building['level'] ?></td>
                    <td><a href="#" ajaxify="<?php echo site_url('ajax/street_ajax/upgrade/' . $building['street_building_id']); ?>" rel="async"><?php echo lang('building_upgrade') ?></a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
<?php foreach ($cooldowns as $cd): ?>
            _html = "<li id='cooldown_<?php echo $cd['cooldown_id'] ?>'></li>";
            $("#cooldown_list").append(_html);
    <?php if ($cd['end_time'] > $current_time): ?>
                    Cooldown.init(<?php echo(($cd['end_time'] - $current_time) * 1000); ?>, 'cooldown_<?php echo $cd['cooldown_id'] ?>');
    <?php endif; ?>
<?php endforeach; ?>
    });
</script>