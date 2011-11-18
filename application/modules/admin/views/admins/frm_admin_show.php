<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('building_type_show') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/building_type') ?>"><?php echo lang('building_type_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/building_type/edit?building_type_id=' . $building_type_id) ?>"><?php echo lang('building_type_edit') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
            <table><!-- Start Table Listing Records -->
                <tr>
                    <td class="fwb"><?php echo lang('admin_id'); ?></td>
                    <td><?php echo $building_type_id ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_display_name'); ?></td>
                    <td><?php echo $name ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_username'); ?></td>
                    <td><?php echo $description ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_role'); ?></td>
                    <td><?php echo $beginning_fee ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('building_type_fee_rate'); ?></td>
                    <td><?php echo $fee_rate ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('building_type_effect'); ?></td>
                    <td><?php echo $effect ?></td>
                </tr>
                <tr>
                    <td class="fwb"><?php echo lang('building_type_effect_rate'); ?></td>
                    <td><?php echo $effect_rate ?></td>
                </tr>
                <tr>
                    <td class="fwb"><?php echo lang('building_type_street_cell'); ?></td>
                    <td><?php echo $street_cell ?></td>
                </tr>
            </table><!-- End Table Listing Records -->
        </div>
    </div>
</div>
