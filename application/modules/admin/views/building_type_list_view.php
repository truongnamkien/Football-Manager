<div class="content-box"><!-- Start Content Box -->

    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('building_type_manager_title') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/building_type/create') ?>" class="current"><?php echo lang('building_type_create') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <?php echo form_open('admin/building_type/remove', array('id' => 'frm_remove_building')) ?>
        <input type="hidden" name="building_type_id" value=""/>
        <?php echo form_close() ?>

        <div id="list" class="tab-content default-tab" style="display: block;">
            <table>
                <thead>
                    <tr>
                        <th><?php echo lang('building_type_id') ?></th>
                        <th><?php echo lang('building_type_name') ?></th>
                        <th><?php echo lang('building_type_description') ?></th>
                        <th><?php echo lang('building_type_fee') ?></th>
                        <th><?php echo lang('building_type_fee_rate') ?></th>
                        <th><?php echo lang('building_type_effect') ?></th>
                        <th><?php echo lang('building_type_effect_rate') ?></th>
                        <th><?php echo lang('building_type_street_cell') ?></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($building_types)):
                        foreach ($building_types as $building):
                            ?>
                            <tr rel="<?php echo $building['building_type_id'] ?>" class="inlineEdit alt-row">
                                <td class="inlineDisable inline_id"><?php echo $building['building_type_id'] ?></td>
                                <td class="inlineDisable" field="name"><?php echo $building['name'] ?></td>
                                <td class="inlineDisable" field="description"><?php echo character_limiter($building['description'], 30) ?></td>
                                <td class="inlineDisable" field="beginning_fee"><?php echo $building['beginning_fee'] ?></td>
                                <td class="inlineDisable" field="fee_rate"><?php echo $building['fee_rate'] ?></td>
                                <td class="inlineDisable" field="effect"><?php echo $building['effect'] ?></td>
                                <td class="inlineDisable" field="effect_rate"><?php echo $building['effect_rate'] ?></td>
                                <td class="inlineDisable" field="street_cell"><?php echo $building['street_cell'] ?></td>

                                <td class="inlineDisable">
                                    <a onclick="remove_building(<?php echo $building['building_type_id'] ?>);" href="#"><?php echo lang('building_type_remove') ?></a> | 
                                    <a href="<?php echo site_url('admin/building_type/show?building_type_id=' . $building['building_type_id']) ?>"><?php echo lang('building_type_show') ?></a> | 
                                    <a href="<?php echo site_url('admin/building_type/edit?building_type_id=' . $building['building_type_id']) ?>"><?php echo lang('building_type_edit') ?></a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table><!-- End Table Listing Records -->
        </div> <!-- End #tab1 -->
    </div> <!-- End .content-box-content -->
</div>

<script type="text/javascript">
    function remove_building(building_id) {
        if (confirm('<?php echo lang('building_type_remove_confirm') ?>')) {
            $('input[name="building_type_id"]').val(building_id);
            $('#frm_remove_building').submit();
        }
    }
</script>