<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Output extends CI_Output
{		
    function _display($output = '', $masterview = FALSE)
    {					
        global $CI;		

        if ( $CI instanceof MY_Controller && $CI->_masterview_enabled || $masterview != FALSE)
        {
            ob_start();
            parent::_display($output);
            $output = ob_get_clean();		

            $CI->_global_vars['PAGE_CONTENT'] = $output;					

            $_CI = & get_instance();

            if ($masterview == FALSE)
                $masterview = $CI->_masterview;

            echo $_CI->load->view($masterview, $CI->_global_vars, TRUE);

            // $_CI->load->library('profiler');
            // echo $_CI->profiler->run();
        }
        else
        {
            parent::_display($output);			
        }
    }
}