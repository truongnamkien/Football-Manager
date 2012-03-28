<div class="pv15 mt80">
    <?php if (validation_errors() || isset($login_failed)): ?> 
        <div class="notification attention png_bg mb20">
            <div>
                <?php echo validation_errors('<p class="tac fwb fs14 mb5">', '</p>'); ?>
                <?php if (isset($error)): ?>
                    <?php foreach ($error['messages'] as $e) : ?>
                        <?php echo '<p class="tac fwb fs14 mb5">' . $error . '</p>'; ?>
                    <?php endforeach ?>            
                <?php endif; ?>
            </div>                            
        </div>                            
    <?php endif; ?>  

    <?php echo form_open('login', array('id' => 'frm_login'), array(), FALSE); ?>
    <div class="ma10">
        <label class="fs18 fwb fLeft w140"><?php echo lang('authen_email'); ?></label>
        <div class="fLeft">
            <input name="email" id="email" value="<?php echo set_value('email') ?>" type="text" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <label class="fs18 fwb fLeft w140"><?php echo lang('authen_password'); ?></label>
        <div class="fLeft">
            <input id="password" name="password" value="<?php echo set_value('password') ?>" type="password" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <button type="submit" class="button fLeft"><?php echo lang('authen_login'); ?></button>
        <ul class="loginFeatures fLeft ml15">
            <li>
                <input value="1" type="checkbox" name="remember_me" id="remember_me" class="fLeft mr5 w20" />
                <label class="fLeft" for="remember"><?php echo lang('authen_remember_me'); ?></label>
            </li>
        </ul>
    </div>
    <?php echo form_close(); ?>
    <div class="clear"></div>
</div>
