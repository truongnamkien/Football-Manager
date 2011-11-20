<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('admin_show') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/admin') ?>"><?php echo lang('admin_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/admin/edit?admin_id=' . $admin_id) ?>"><?php echo lang('admin_edit') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
            <table><!-- Start Table Listing Records -->
                <tr>
                    <td class="fwb"><?php echo lang('admin_id'); ?></td>
                    <td><?php echo $admin_id ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_display_name'); ?></td>
                    <td><?php echo $display_name ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_username'); ?></td>
                    <td><?php echo $username ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('admin_role'); ?></td>
                    <td><?php echo $role ?></td>
                </tr>
            </table><!-- End Table Listing Records -->
        </div>
    </div>
</div>
