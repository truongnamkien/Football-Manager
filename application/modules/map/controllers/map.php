<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Map extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('street_model'));
    }

    public function index() {
        $user_info = $this->my_auth->get_user_info();
        $this->display(array('street' => $user_info['street']));
    }

    public function display($info) {
        if (isset($info['area'])) {
            $area = $info['area'];
        } else {
            $street = $info['street'];
            $area = intval($street['x_coor'] / Street_model::AREA_WIDTH) + intval($street['y_coor'] / Street_model::AREA_HEIGHT) * (Street_model::MAP_HEIGHT / Street_model::AREA_HEIGHT);
        }

        $data = array();
        $streets = $this->street_model->get_street_by_area($area);
        if ($streets['return_code'] == API_SUCCESS && !empty($streets['data'])) {
            $data['streets'] = $streets['data'];
        }
        $this->load->view('pagelet_map_view', $data);
    }

}