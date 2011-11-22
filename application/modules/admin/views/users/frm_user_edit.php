<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('user_edit') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/users') ?>"><?php echo lang('user_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/users/show?user_id=' . $user_id) ?>"><?php echo lang('user_show') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;">
            <?php echo form_open('admin/users/reset_password', array('id' => 'frm_reset_password_user')) ?>
                <input type="hidden" name="user_id" value=""/>
            <?php echo form_close() ?>
            <form action="<?php echo site_url('admin/users/edit'); ?>" method="post">
                <input name="user_id" type="hidden" value="<?php echo $user_id ?>">
                <input name="password" type="hidden" value="<?php echo $password ?>">
                <div class="borderGrayLight pa15 feekback mv10">
                    
                    <p><label class="labelField fLeft fwb"><?php echo lang('user_email'); ?></label></p>
                    <p><label class="textarea rounded" disabled="disabled" name="email"><?php echo $email ?> </label></p>

                    <p><label class="labelField fLeft fwb"><?php echo lang('user_display_name'); ?></label></p>
                    <p><input class="mt10" name="display_name" value="<?php echo $display_name ?>"></p>
                    <?php if (form_error('display_name')): ?>
                        <?php echo form_error('display_name', '<label>', '</label>') ?>
                    <?php endif; ?>

                    <p><label class="labelField fLeft fwb"><?php echo lang('user_street_id'); ?></label></p>
                    <p><label class="textarea rounded" disabled="disabled" name='user_street_id'><?php echo $street_id ?> </label></p>

                    <p><label class="labelField fLeft fwb"><?php echo lang('user_status'); ?></label></p>
                    <p><select class="mt10" name="user_status" > 
                            <?php 
                            if (isset($status)):
                                foreach ($status as $index => $value ):
                            ?>
                                    <option value="<?php echo $index ?>"> <?php echo $value ?> </option>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </p>
                    <a onclick="reset_password(<?php echo $user_id ?>);" href="#"><?php echo lang('user_reset_password') ?></a>
                    <p class="tac pt10"><button class="uiBtn dpi" name="submit"><?php echo lang('admin_edit'); ?></button></p>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function reset_password(user_id) {
        if (confirm('<?php echo lang('user_reset_password_confirm') ?>')) {
            $('input[name="user_id"]').val(user_id);
            alert ( "Default pass la: 123456");
            $('#frm_reset_password_user').submit();
        }
    }
</script>