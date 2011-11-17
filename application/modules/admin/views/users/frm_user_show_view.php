<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('user_show') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/users') ?>"><?php echo lang('user_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/users/edit?user_id=' . $user_id) ?>"><?php echo lang('user_edit') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;"> <!-- This is the target div. id must match the href of this div's tab -->
            <table><!-- Start Table Listing Records -->
                <tr>
                    <td class="fwb"><?php echo lang('user_id'); ?></td>
                    <td><?php echo $user_id ?></td>
                </tr>
                
                <tr>
                    <td class="fwb"><?php echo lang('user_email'); ?></td>
                    <td><?php echo $email ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('user_display_name'); ?></td>
                    <td><?php echo $display_name ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('user_status'); ?></td>
                    <td><?php echo $status[$user_status] ?></td>
                </tr>

                <tr>
                    <td class="fwb"><?php echo lang('user_street_id'); ?></td>
                    <td><?php echo $street_id ?></td>
                </tr>

            </table><!-- End Table Listing Records -->
        </div>
    </div>
</div>
