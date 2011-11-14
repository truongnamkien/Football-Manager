<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('street_building_model', 'building_type_model'));
    }

    public function index() {
        $user_info = $this->my_auth->get_user_info();
        $street_info = $user_info['street'];
        $buildings = $this->street_building_model->get_all_building($street_info['street_id']);
        $data['buildings'] = array();
        if ($buildings['return_code'] && !empty($buildings['data'])) {
            $buildings = $buildings['data'];
            foreach ($buildings as $building) {
                $type = $this->street_building_model->get_building_type($building['building_type_id']);
                if ($type['return_code'] == API_SUCCESS && !empty($type['data'])) {
                    $data['buildings'][] = array_merge($buildings, $type['data']);
                }
            }
        }
        $this->load->view('street_building_view', $data);
    }

}