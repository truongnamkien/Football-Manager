<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Map extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('map_library', 'street_library'));
        $this->load->model(array('street_model'));
        $this->load->language(array('map'));
    }

    public function index() {
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        $this->display(array('street' => $street));
    }

    public function display($info) {
        if (isset($info['area'])) {
            $data['streets'] = $this->map_library->get($info['area']);
            $data['row'] = intval($info['area'] / Street_Model::AREA_HEIGHT);
            $data['col'] = $info['area'] % Street_Model::AREA_HEIGHT;
        } else {
            $street = $info['street'];
            $data['streets'] = $this->map_library->get_by_coor($street['x_coor'], $street['y_coor']);
            $data['col'] = intval($street['x_coor'] / Street_Model::AREA_WIDTH);
            $data['row'] = intval($street['y_coor'] / Street_Model::AREA_HEIGHT);
        }
        
        $this->load->view('pagelet_map_view', $data);
    }

}