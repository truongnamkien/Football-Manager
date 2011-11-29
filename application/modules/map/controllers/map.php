<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Map extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('map_library'));
    }

    public function index() {
        $user_info = $this->my_auth->get_user_info();
        $this->display(array('street' => $user_info['street']));
    }

    public function display($info) {
        if (isset($info['area'])) {
            $data['streets'] = $this->map_library->get($info['area']);
        } else {
            $street = $info['street'];
            $data['streets'] = $this->map_library->get_by_coor($street['x_coor'], $street['y_coor']);
        }
        $this->load->view('pagelet_map_view', $data);
    }

}