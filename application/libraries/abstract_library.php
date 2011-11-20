<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Abstract_Library {
    protected static $CI = NULL;

    public function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->driver('cache');
    }

}
