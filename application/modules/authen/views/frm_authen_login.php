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
    <?php echo form_open('login', array('id' => 'frm_login'), array(), FALSE); ?>
    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <label><?php echo lang('authen_email'); ?></label>
        <input name="email" value="<?php echo set_value('email') ?>" type="text" />
    </div><!-- end uiBox2Field -->

    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <label><?php echo lang('authen_password'); ?></label>
        <input name="password" value="<?php echo set_value('password') ?>" type="password" />
    </div><!-- end uiBox2Field -->

    <!-- uiBox2Field -->
    <div class="uiBox2Field mb15">
        <button type="submit" class="button fLeft"><?php echo lang('authen_login'); ?></button>
        <ul class="loginFeatures fLeft ml15">
            <li>
                <input value="1" type="checkbox" name="remember_me" class="fLeft mr5" />
                <label for="remember"><?php echo lang('authen_remember_me'); ?></label>
            </li>
        </ul>
    </div><!-- end uiBox2Field -->
    <?php echo form_close(); ?>
    <div class="clear"></div>
</div><!-- end uiBox2 -->        
