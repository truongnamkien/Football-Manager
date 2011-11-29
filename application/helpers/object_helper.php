<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

if (!function_exists('get_object_key')) {
    function get_object_key($object, $type) {
        foreach ($object as $key => $value) {
            if (strpos($key, $type) !== FALSE && strpos($key, '_id') !== FALSE) {
                return $key;
            }
        }
        return key($object);
    }
}