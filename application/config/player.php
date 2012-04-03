<?php

$config['player_max_point_per_level'] = 30;
$config['player_max_point_for_position'] = 70;
$config['player_min_point_for_position'] = 60;

$config['player_position_list'] = array('goalkeeper', 'def_center', 'def_wing', 'mid_center', 'mid_wing', 'for_center', 'for_wing');

$config['player_index_list'] = array('physical', 'flexibility', 'goalkeeper', 'defence', 'shooting', 'passing', 'thwart', 'speed');

$config['player_rate_for_postion'] = array(
    'goalkeeper' => array('goalkeeper' => 3),
    'def_center' => array('defence' => 2, 'thwart' => 1),
    'def_wing' => array('defence' => 1, 'speed' => 2),
    'mid_center' => array('thwart' => 1, 'passing' => 2),
    'mid_wing' => array('passing' => 1, 'speed' => 2),
    'for_center' => array('passing' => 1, 'shooting' => 2),
    'for_wing' => array('shooting' => 1, 'speed' => 2)
);

$config['player_num_of_player'] = array(
    'goalkeeper' => 2,
    'def_center' => 3,
    'def_wing' => 2,
    'mid_center' => 2,
    'mid_wing' => 2,
    'for_center' => 2,
    'for_wing' => 3
);

$config['player_num_of_npc'] = array(
    'goalkeeper' => 1,
    'def_center' => 2,
    'def_wing' => 2,
    'mid_center' => 1,
    'mid_wing' => 2,
    'for_center' => 1,
    'for_wing' => 2
);
