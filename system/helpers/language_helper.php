<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/language_helper.html
 */
// ------------------------------------------------------------------------

/**
 * Lang
 *
 * Fetches a language variable and optionally outputs a form label
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the id of the form element
 * @return	string
 */
if (!function_exists('lang')) {

    function lang($line, $id = '') {
        $CI = & get_instance();
        $line = $CI->lang->line($line);

        if ($line) {
            $args = func_get_args();

            if (count($args) > 1) {
                if (is_array($args[2]) && count($args[2])) {
                    foreach ($args[2] as $key => $value)
                        $line = str_replace('%' . $key, $value, $line);
                } else {
                    // remove $line & $id
                    array_shift($args);
                    $args[0] = $line;
                    $line = call_user_func_array('sprintf', $args);
                }
            }

            if ($id != '') {
                $line = '<label for="' . $id . '">' . $line . "</label>";
            }
        }

        return $line;
    }

}

if (!function_exists('lang_key')) {

    function lang_key($line, $id = '', $data = array()) {
        $CI = & get_instance();
        $line = $CI->lang->line($line);

        if ($line) {
            foreach ($data as $key => $val) {

                $line = str_replace("%$key", $val, $line);
            }
        }

        if ($id != '') {
            $line = '<label for="' . $id . '">' . $line . "</label>";
        }

        return $line;
    }

}


// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */
