<div>
    <h2><?php echo lang('authen_register'); ?></h2>

    <!-- rightbox: register form -->
    <div class="uiBox2 grid_12 prefix_1 suffix_2 pv15">
        <!-- begin validation error -->
        <?php if (isset($error)): ?>
            <div class="uiBox2Message pv20 mb15">            
                <?php foreach ($error['messages'] as $e) : ?>
                    <?php echo '<p>' . $e . '</p>'; ?>
                <?php endforeach ?>
            </div>                            
        <?php endif; ?>  
        <!-- end validation error -->

        <?php
        echo form_open(site_url('admin/admin/register'), array(
            'id' => 'registerForm',
        ));
        ?>
        <div class="uiBox2Form">
            <!-- LAST NAME -->
            <div id="display_name">
                <label class="labelField fs18 fwb">
                    <?php echo lang('authen_display_name'); ?>
                    <span class="require">*</span>                    
                </label>
                <div class="contentField">
                    <input name="display_name" type="text" value="<?php echo set_value('display_name') ?>" />
                    <?php if (form_error('display_name')): ?>
                        <?php echo form_error('display_name', '<label class="error">', '</label>') ?>
                    <?php endif; ?>   
                </div>
            </div>
            <!-- end field -->

            <!-- EMAIL -->
            <div id="email">
                <label class="labelField fs18 fwb">
                    <?php echo lang('authen_username') ?>
                    <span class="require">*</span>
                </label>
                <div class="contentField">
                    <input name="username" id="username" type="text" value="<?php echo set_value('username') ?>" />
                    <?php if (form_error('username')): ?>
                        <?php echo form_error('username', '<label class="error">', '</label>') ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- PASSWORD -->
            <div class="uiBox2Field grid_6 alpha mb10">
                <label class="labelField fs18 fwb">
                    <?php echo lang('authen_password'); ?>
                    <span class="require">*</span>
                </label>
                <div class="contentField">
                    <label class="labelPassword"><input name="password" type="password" value="<?php echo set_value('password') ?>"/></label>
                    <?php if (form_error('password')): ?>
                        <?php echo form_error('password', '<label class="error">', '</label>') ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- PASSWORD CONFIRM -->
            <div class="uiBox2Field grid_6 alpha mb10">
                <label class="labelField fs18 fwb">
                    <?php echo lang('authen_password_confirm'); ?>
                    <span class="require">*</span>
                </label>
                <div class="contentField">
                    <label class="labelPassword"><input name="password_confirm" type="password" value="<?php echo set_value('password_confirm') ?>"/></label>
                    <?php if (form_error('password_confirm')): ?>
                        <?php echo form_error('password_confirm', '<label class="error">', '</label>') ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- uiBox2Field -->
            <div class="uiBox2Field mb10">
                <label class="labelField fs18 fwb fLeft"></label>
                <div class="contentField">
                    <button name="btnRegister" class="uiBtn" type="submit"><?php echo lang('authen_register'); ?></button>
                </div>                    
            </div><!-- end uiBox2Field -->

        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- end rightbox-->
</div>