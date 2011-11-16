<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('admin_edit') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/admin') ?>"><?php echo lang('building_type_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/adin/show?admin_id=' . $admin_id) ?>"><?php echo lang('admin_show') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;">
            <form action="<?php echo site_url('admin/admin/edit'); ?>" method="post">
                <input name="admin_id" type="hidden" value="<?php echo $admin_id ?>">
                <input name="username" type="hidden" value="<?php echo $username ?>">
                <input name="password" type="hidden" value="<?php echo $password ?>">
                <div class="borderGrayLight pa15 feekback mv10">
                    <p><label class="labelField fLeft fwb"><?php echo lang('admin_username'); ?></label></p>
                    <p><label class="textarea rounded" disabled="disabled" name="username"><?php echo $username ?> </label></p>

                    <p><label class="labelField fLeft fwb"><?php echo lang('admin_display_name'); ?></label></p>
                    <p><input class="mt10" name="display_name" value="<?php echo $display_name ?>"></p>
                    <?php if (form_error('display_name')): ?>
                        <?php echo form_error('display_name', '<label>', '</label>') ?>
                    <?php endif; ?>    

                    <p><label class="labelField fLeft fwb"><?php echo lang('admin_role'); ?></label></p>
                    <p><select class="mt10" name="role" > 
                            <?php 
                            if (isset($roles)):
                                foreach ($roles as $index => $value ):
                            ?>
                                    <option value="<?php echo $index ?>"> <?php echo $value ?> </option>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </p>

                    <p class="tac pt10"><button class="uiBtn dpi" name="submit"><?php echo lang('admin_edit'); ?></button></p>
                </div>
            </form>
        </div>
    </div>
</div>
