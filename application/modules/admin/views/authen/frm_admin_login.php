<div class="pv15 mt80">
    <h1 class="tac mb15 fs36"><?php echo lang('authen_login'); ?></h1>

    <?php if (validation_errors() || isset($error)): ?> 
        <div class="notification attention png_bg mb20">
            <div>
                <?php echo validation_errors('<p class="tac fwb fs14 mb5">', '</p>'); ?>
                <?php if (isset($error)): ?>
                    <?php foreach ($error['messages'] as $e) : ?>
                        <?php echo '<p class="tac fwb fs14 mb5">' . $e . '</p>'; ?>
                    <?php endforeach ?>            
                <?php endif; ?>
            </div>                            
        </div>                            
    <?php endif; ?>  

    <?php echo form_open('admin_login', array('id' => 'frm_login'), array(), FALSE); ?>
    <div class="ma10">
        <label for="username" class="fs18 fwb fLeft w140"><?php echo lang('authen_username'); ?></label>
        <div class="fLeft">
            <input name="username" id="username" value="<?php echo set_value('username') ?>" type="text" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>


    <div class="ma10">
        <label for="password" class="fs18 fwb fLeft w140"><?php echo lang('authen_password'); ?></label>
        <div class="fLeft">
            <input name="password" id="password" value="<?php echo set_value('password') ?>" type="password" class="inputText" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

    <div class="ma10 tac">
        <button type="submit" class="button"><?php echo lang('authen_login'); ?></button>
    </div>
    <?php echo form_close(); ?>
    <div class="clear"></div>
</div>
