<div class="content-box"><!-- Start Content Box -->
    <div class="content-box-header">
        <h3 style="cursor: s-resize;"><?php echo lang('building_type_edit') ?></h3>
        <ul class="content-box-tabs">
            <li><a href="<?php echo site_url('admin/building_type') ?>"><?php echo lang('building_type_back_list') ?></a></li>
            <li><a href="<?php echo site_url('admin/building_type/show?building_type_id=' . $building_type_id) ?>"><?php echo lang('building_type_show') ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>

    <div class="content-box-content">
        <div id="list" class="tab-content default-tab" style="display: block;">
            <form action="<?php echo site_url('admin/building_type/edit'); ?>" method="post">
                <input name="building_type_id" value="<?php echo $building_type_id ?>">
                <div class="borderGrayLight pa15 feekback mv10">
                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_name'); ?></label></p>
                    <p><input class="mt10" name="name" value="<?php set_value('name') ?>"></p>
                    <?php if (form_error('name')): ?>
                        <?php echo form_error('name', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_description'); ?></label></p>
                    <p><input class="mt10" name="description" value="<?php set_value('description') ?>"></p>
                    <?php if (form_error('description')): ?>
                        <?php echo form_error('description', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_fee'); ?></label></p>
                    <p><input class="mt10" name="beginning_fee" value="<?php set_value('beginning_fee') ?>"></p>
                    <?php if (form_error('beginning_fee')): ?>
                        <?php echo form_error('beginning_fee', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_fee_rate'); ?></label></p>
                    <p><input class="mt10" name="fee_rate" value="<?php set_value('fee_rate') ?>"></p>
                    <?php if (form_error('fee_rate')): ?>
                        <?php echo form_error('fee_rate', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_effect'); ?></label></p>
                    <p><input class="mt10" name="effect" value="<?php set_value('effect') ?>"></p>
                    <?php if (form_error('effect')): ?>
                        <?php echo form_error('effect', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_effect_rate'); ?></label></p>
                    <p><input class="mt10" name="effect_rate" value="<?php set_value('effect_rate') ?>"></p>
                    <?php if (form_error('effect_rate')): ?>
                        <?php echo form_error('effect_rate', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p><label class="labelField fLeft fwb"><?php echo lang('building_type_street_cell'); ?></label></p>
                    <p><input class="mt10" name="street_cell" value="<?php set_value('street_cell') ?>"></p>
                    <?php if (form_error('street_cell')): ?>
                        <?php echo form_error('street_cell', '<label>', '</label>') ?>
                    <?php endif; ?>                           

                    <p class="tac pt10"><button class="uiBtn dpi" name="submit"><?php echo lang('building_type_edit'); ?></button></p>
                </div>
            </form>
        </div>
    </div>
</div>
