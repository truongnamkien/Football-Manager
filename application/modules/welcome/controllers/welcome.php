<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $user_id = $this->my_auth->get_user_id();
        
        $this->load->view('welcome_home_page');
    }

}