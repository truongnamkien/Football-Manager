<div class="content-box"><!-- Start Content Box -->

    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('building_type_manager_title') ?></h3>
    </div>

    <div class="content-box-content">
        <?php echo form_open('admin/users/remove', array('id' => 'frm_remove_user')) ?>
        <input type="hidden" name="user_id" value=""/>
        <?php echo form_close() ?>

        <div id="list" class="tab-content default-tab" style="display: block;">
            <table>
                <thead>
                    <tr>
                        <th><?php echo lang('user_id') ?></th>
                        <th><?php echo lang('user_display_name') ?></th>
                        <th><?php echo lang('user_email') ?></th>
                        <th><?php echo lang('user_status') ?></th>
                        <th><?php echo lang('user_street_id') ?></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($users)):
                        foreach ($users as $user):
                            ?>
                            <tr rel="<?php echo $user['user_id'] ?>" class="inlineEdit alt-row">
                                <td class="inlineDisable inline_id"><?php echo $user['user_id'] ?></td>
                                <td class="inlineDisable" field="display_name"><?php echo $user['display_name'] ?></td>
                                <td class="inlineDisable" field="email"><?php echo character_limiter($user['email'], 30) ?></td>
                                <td class="inlineDisable" field="user_status"><?php echo $status[$user['user_status']] ?></td>
                                <td class="inlineDisable" field="street_id"><?php echo $user['street_id'] ?></td>
                                <td class="inlineDisable">
                                    <a onclick="remove_building(<?php echo $user['user_id'] ?>);" href="#"><?php echo lang('user_remove') ?></a> | 
                                    <a href="<?php echo site_url('admin/users/show?user_id=' . $user['user_id']) ?>"><?php echo lang('user_show') ?></a> | 
                                    <a href="<?php echo site_url('admin/users/edit?user_id=' . $user['user_id']) ?>"><?php echo lang('user_edit') ?></a>
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
        if (confirm('<?php echo lang('user_remove_confirm') ?>')) {
            $('input[name="user_id"]').val(user_id);
            $('#frm_remove_user').submit();
        }
    }
</script>