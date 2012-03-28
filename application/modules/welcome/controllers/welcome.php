<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Welcome extends MY_Outer_Controller {

    public function index() {
        if ($this->my_auth->logged_in()) {
            redirect('street');
        }

        $this->set_title(lang('general_football'));
        $this->load->view('welcome_home_page');
    }

}