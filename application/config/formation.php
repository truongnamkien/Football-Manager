<?php

$config['formation_all_format'] = array(
    'none' => array('number' => 0, 'position' => array()),
    '1A' => array('number' => 1, 'position' => array('middle')),
    '1B' => array('number' => 1, 'position' => array('top')),
    '1C' => array('number' => 1, 'position' => array('bottom')),
    '2A' => array('number' => 2, 'position' => array('middle', 'middle')),
    '2B' => array('number' => 2, 'position' => array('top', 'bottom')),
    '2C' => array('number' => 2, 'position' => array('top', 'middle')),
    '2D' => array('number' => 2, 'position' => array('middle', 'bottom')),
    '3A' => array('number' => 3, 'position' => array('middle', 'middle', 'middle')),
    '3B' => array('number' => 3, 'position' => array('middle', 'top', 'middle')),
    '3C' => array('number' => 3, 'position' => array('middle', 'bottom', 'middle')),
    '3D' => array('number' => 3, 'position' => array('top', 'middle', 'top')),
    '3E' => array('number' => 3, 'position' => array('bottom', 'middle', 'bottom')),
);

$config['formation_format_for_area'] = array(
    'wing' => array('none', '1A', '1B', '1C'),
    'center' => array_keys($config['formation_all_format']),
);

$config['formation_all_area'] = array(
    'for_wing',
    'for_center',
    'mid_wing',
    'mid_center',
    'def_wing',
    'def_center',
);