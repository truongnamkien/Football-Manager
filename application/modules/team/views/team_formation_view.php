<div class="content-box">
    <form method="post" rel="async" action="<?php echo site_url('ajax/team_ajax/save_formation'); ?>">
        <div class="content-box-header">
            <h3><?php echo lang('team_formation') ?></h3>

            <button class="fRight ma5 button" type="submit"><?php echo lang('team_formation_save_btn'); ?></button>
            <select class="fRight ma10 w90" name="formation_id">
                <?php foreach ($default_formations as $form): ?>
                    <option value="<?php echo $form['formation_id']; ?>"><?php echo $form['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>

        <div>
            <div id="formation_field">
                <?php echo Modules::run('team/_pagelet_formation', $formation['formation_id'], $team_id); ?>
            </div>

            <div id="player_list" class="fLeft">
                <?php foreach ($player_list as $player): ?>
                    <p><span class="fwb"><?php echo $player['player_id']; ?></span> <?php echo $player['last_name'] . ' ' . $player['middle_name'] . ' ' . $player['first_name']; ?></p>
                <?php endforeach; ?>
            </div>
            <div class="clear"></div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="formation_id"]').change(function() {
            var _form_id = $(this).val();
            var _uri = '<?php echo site_url('ajax/team_ajax/update_formation?formation_id='); ?>' + _form_id;
            AsyncRequest.bootstrap(new URI(_uri), this);
        });
    });
</script>
