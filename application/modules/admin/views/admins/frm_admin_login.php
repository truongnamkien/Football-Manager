<div class="uiBox2 rounded shadow grid_12 push_6 pv15 mt80">
    <h1 class="tac mb15 fs36"><?php echo lang('authen_login'); ?></h1>

    <!-- begin validation error -->
    <?php if (validation_errors() || isset($login_failed)): ?> 
        <div class="uiBox2Message pv20 mb15">
            <?php echo validation_errors('<p class="tac fwb fs14 mb5">', '</p>'); ?>
            <?php if (isset($login_failed)): ?>
                <?php foreach ($login_failed['messages'] as $error) : ?>
                    <?php echo '<p class="tac fwb fs14 mb5">' . $error . '</p>'; ?>
                <?php endforeach ?>            
            <?php endif; ?>
        </div>                            
    <?php endif; ?>  
    <!-- end validation error -->

    <!-- begin form -->
    <?php echo form_open('admin/login', array('id' => 'frm_login'), array(), FALSE); ?>
    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <label><?php echo lang('authen_username'); ?></label>
        <input name="username" value="<?php echo set_value('username') ?>" type="text" />
    </div><!-- end uiBox2Field -->

    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <label><?php echo lang('authen_password'); ?></label>
        <input name="password" value="<?php echo set_value('password') ?>" type="password" />
    </div><!-- end uiBox2Field -->

    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <button type="submit" class="uiBtn fLeft"><?php echo lang('authen_login'); ?></button>
    </div>
    <?php echo form_close(); ?>
    <div class="clear"></div>
</div>
