<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('building_type_create') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/building_type') ?>"><?php echo lang('building_type_back_list') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;">
            <form action="<?php echo site_url('admin/building_type/create'); ?>" method="post">
                <div class="borderGrayLight pa15 feekback mv10">
                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_name'); ?></label></p>
                    <p><input class="mt10" name="name" value="<?php echo $name ?>"></p>
                    <?php if (form_error('name')): ?>
                        <?php echo form_error('name', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_description'); ?></label></p>
                    <p><textarea class="textarea rounded" name="description"><?php set_value('description') ?></textarea></p>
                    <?php if (form_error('description')): ?>
                        <?php echo form_error('description', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_fee'); ?></label></p>
                    <p><input class="mt10" name="beginning_fee" value="<?php echo $beginning_fee ?>"></p>
                    <?php if (form_error('beginning_fee')): ?>
                        <?php echo form_error('beginning_fee', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_fee_rate'); ?></label></p>
                    <p><input class="mt10" name="fee_rate" value="<?php echo $fee_rate ?>"></p>
                    <?php if (form_error('fee_rate')): ?>
                        <?php echo form_error('fee_rate', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_effect'); ?></label></p>
                    <p><input class="mt10" name="effect" value="<?php echo $effect ?>"></p>
                    <?php if (form_error('effect')): ?>
                        <?php echo form_error('effect', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_effect_rate'); ?></label></p>
                    <p><input class="mt10" name="effect_rate" value="<?php echo $effect_rate ?>"></p>
                    <?php if (form_error('effect_rate')): ?>
                        <?php echo form_error('effect_rate', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_street_cell'); ?></label></p>
                    <p><input class="mt10" name="street_cell" value="<?php echo $street_cell ?>"></p>
                    <?php if (form_error('street_cell')): ?>
                        <?php echo form_error('street_cell', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p class="tac pt10"><button class="uiBtn dpi" name="submit"><?php echo lang('building_type_create_submit'); ?></button></p>
                </div>
            </form>
        </div>
    </div>
</div>
