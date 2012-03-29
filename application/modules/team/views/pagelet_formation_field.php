<div class="formation_area" id="formation_for_left"><?php echo Modules::run('team/_pagelet_formation_area', 'for_wing', $formation['for_wing'], $team_id); ?></div>
<div class="formation_area" id="formation_for_center"><?php echo Modules::run('team/_pagelet_formation_area', 'for_center', $formation['for_center'], $team_id); ?></div>
<div class="formation_area" id="formation_for_right"><?php echo Modules::run('team/_pagelet_formation_area', 'for_wing', $formation['for_wing'], $team_id); ?></div>
<div class="formation_area" id="formation_mid_left"><?php echo Modules::run('team/_pagelet_formation_area', 'mid_wing', $formation['mid_wing'], $team_id); ?></div>
<div class="formation_area" id="formation_mid_center"><?php echo Modules::run('team/_pagelet_formation_area', 'mid_center', $formation['mid_center'], $team_id); ?></div>
<div class="formation_area" id="formation_mid_right"><?php echo Modules::run('team/_pagelet_formation_area', 'mid_wing', $formation['mid_wing'], $team_id); ?></div>
<div class="formation_area" id="formation_def_left"><?php echo Modules::run('team/_pagelet_formation_area', 'def_wing', $formation['def_wing'], $team_id); ?></div>
<div class="formation_area" id="formation_def_center"><?php echo Modules::run('team/_pagelet_formation_area', 'def_center', $formation['def_center'], $team_id); ?></div>
<div class="formation_area" id="formation_def_right"><?php echo Modules::run('team/_pagelet_formation_area', 'def_wing', $formation['def_wing'], $team_id); ?></div>

<div class="formation_goalkeeper"></div>
<div class="formation_goalkeeper"><?php echo Modules::run('team/_pagelet_player_select', $team_id, 'goalkeeper'); ?></div>
<div class="formation_goalkeeper"></div>

<div class="clear"></div>
