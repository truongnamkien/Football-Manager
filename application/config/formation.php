<?php

$config['formation_all_format'] = array(
    'none' => array('col' => 0, 'number' => 0, 'position' => array()),
    '1A' => array('col' => 1, 'number' => 1, 'position' => array(2)),
    '1B' => array('col' => 1, 'number' => 1, 'position' => array(1)),
    '1C' => array('col' => 1, 'number' => 1, 'position' => array(3)),
    '2A' => array('col' => 2, 'number' => 2, 'position' => array(3, 4)),
    '2B' => array('col' => 1, 'number' => 2, 'position' => array(1, 3)),
    '2C' => array('col' => 1, 'number' => 2, 'position' => array(1, 2)),
    '2D' => array('col' => 1, 'number' => 2, 'position' => array(2, 3)),
    '3A' => array('col' => 3, 'number' => 3, 'position' => array(4, 5, 6)),
    '3B' => array('col' => 3, 'number' => 3, 'position' => array(4, 2, 6)),
    '3C' => array('col' => 3, 'number' => 3, 'position' => array(4, 8, 6)),
    '3D' => array('col' => 3, 'number' => 3, 'position' => array(1, 5, 3)),
    '3E' => array('col' => 3, 'number' => 3, 'position' => array(7, 5, 9)),
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