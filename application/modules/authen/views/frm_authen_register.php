<div class="pv15 mt80">
    <?php if (isset($error) || validation_errors()): ?>
        <div class="notification attention png_bg mb20">
            <div>
                <?php if (isset($error)): ?>
                    <?php foreach ($error['messages'] as $e) : ?>
                        <?php echo '<p class="tac fwb fs14 mb5">' . $e . '</p>'; ?>
                    <?php endforeach ?>
                <?php endif ?>        
                <?php echo validation_errors('<p class="tac fwb fs14 mb5">', '</p>'); ?>
            </div>
        </div>
    <?php endif; ?>  

    <?php echo form_open(site_url('authen/register'), array('id' => 'registerForm')); ?>
    <div class="ma10">
        <label for="display_name" class="fs18 fwb fLeft w140">
            <?php echo lang('authen_display_name'); ?>
            <span class="required">*</span>                    
        </label>
        <div class="fLeft">
            <input autocomplete="off" id="display_name" name="display_name" type="text" value="<?php echo set_value('display_name') ?>" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <label for="email" class="fs18 fwb fLeft w140">
            <?php echo lang('authen_email') ?>
            <span class="required">*</span>
        </label>
        <div class="fLeft">
            <input autocomplete="off" name="email" id="email" type="text" value="<?php echo set_value('email') ?>" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <label for="password" class="fs18 fwb fLeft w140">
            <?php echo lang('authen_password'); ?>
            <span class="required">*</span>
        </label>
        <div class="fLeft">
            <input autocomplete="off" id="password" name="password" type="password" value="<?php echo set_value('password') ?>" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <label for="password_confirm" class="fs18 fwb fLeft w140">
            <?php echo lang('authen_password_confirm'); ?>
            <span class="required">*</span>
        </label>
        <div class="fLeft">
            <input autocomplete="off" id="password_confirm" name="password_confirm" type="password" value="<?php echo set_value('password_confirm') ?>" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10">
        <label for="team_name" class="fs18 fwb fLeft w140">
            <?php echo lang('authen_team_name'); ?>
            <span class="required">*</span>
        </label>
        <div class="fLeft">
            <input autocomplete="off" name="team_name" id="team_name" type="text" value="<?php echo set_value('team_name') ?>" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10 tac">
        <button name="btnRegister" class="button" type="submit"><?php echo lang('authen_register'); ?></button>
    </div>
    <?php echo form_close(); ?>
</div>