<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Navigator extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->language('navigator');
    }

    public function _main_nav() {
        $data['main_navs'] = array(
//            'profile' => array('user'),
//            'street' => array('user'),
            'team' => $this->_team_sub_nav(),
        );
        $data['controller'] = $this->router->fetch_class();
        $data['method'] = $this->router->fetch_method();

        $this->load->view('navigator/main_nav_view', $data);
    }

    private function _team_sub_nav() {
        return array('navs' => array(
            'player' => site_url('team/player'),
            'formation' => site_url('team/formation'),
        ));
        
    }
}
