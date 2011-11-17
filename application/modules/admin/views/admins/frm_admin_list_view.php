<div class="content-box"><!-- Start Content Box -->

    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('admin_manager_title') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/admin/register') ?>" class="current"><?php echo lang('admin_create') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <?php echo form_open('admin/admin/remove', array('id' => 'frm_remove_admin')) ?>
        <input type="hidden" name="admin_id" value=""/>
        <?php echo form_close() ?>

        <div id="list" class="tab-content default-tab" style="display: block;">
            <table>
                <thead>
                    <tr>
                        <th><?php echo lang('admin_id') ?></th>
                        <th><?php echo lang('admin_display_name') ?></th>
                        <th><?php echo lang('admin_username') ?></th>
                        <th><?php echo lang('admin_role') ?></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($admins)):
                        foreach ($admins as $admin):
                            ?>
                            <tr rel="<?php echo $admin['admin_id'] ?>" class="inlineEdit alt-row">
                                <td class="inlineDisable inline_id"><?php echo $admin['admin_id'] ?></td>
                                <td class="inlineDisable" field="display_name"><?php echo $admin['display_name'] ?></td>
                                <td class="inlineDisable" field="username"><?php echo $admin['username'] ?></td>
                                <td class="inlineDisable" field="role"><?php echo $roles[$admin['role']] ?></td>

                                <td class="inlineDisable">
                                    <a onclick="remove_admin(<?php echo $admin['admin_id'] ?>);" href="#"><?php echo lang('admin_remove') ?></a> | 
                                    <a href="<?php echo site_url('admin/admin/show?admin_id=' . $admin['admin_id']) ?>"><?php echo lang('admin_show') ?></a> | 
                                    <a href="<?php echo site_url('admin/admin/edit?admin_id=' . $admin['admin_id']) ?>"><?php echo lang('admin_edit') ?></a>
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
    function remove_admin(admin_id) {
        if (confirm('<?php echo lang('admin_remove_confirm') ?>')) {
            $('input[name="admin_id"]').val(admin_id);
            $('#frm_remove_admin').submit();
        }
    }
</script>