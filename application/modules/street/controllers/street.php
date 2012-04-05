<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street extends MY_Inner_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('building_type_library', 'street_library'));
        $this->load->language(array('building', 'street', 'navigator'));
        $this->load->config('street', TRUE);
    }

    /**
     * Trang sơ đồ building trong nội thành
     */
    public function indoor() {
        $this->set_title(lang('navigator_sub_nav_street_indoor'));
        $data['offset'] = 1;
        $this->_pagelet_street_view($data);
    }

    /**
     * Trang sơ đồ building trong ngoại thành
     */
    public function outdoor() {
        $this->set_title(lang('navigator_sub_nav_street_outdoor'));
        $data['offset'] = 2;
        $this->_pagelet_street_view($data);
    }

    /**
     * Trang thông tin chi tiết của building
     * @param type $cell 
     */
    public function building($cell = FALSE) {
        if ($cell === FALSE) {
            show_404();
        }
        $street_building_config = $this->config->item('street_building_area', 'street');
        $index = intval(($cell - 1) / 2);

        $street_id = $this->my_auth->get_street_id();
        $building_types = $this->building_library->get_by_street_cell($street_id, $cell);

        $data['name'] = (empty($building_types) ? '' : (isset($building_types['name']) ? $building_types['name'] : lang('building_type_stadium')));
        $this->set_title($data['name']);

        if (!empty($building_types) && isset($building_types['building_type_id'])) {
            $building_types = array($building_types);
        }

        $data['building_types'] = $building_types;
        $data['image'] = $street_building_config[$index]['image'][($cell + 1) % 2];

        $this->load->view('street_building_view', $data);
    }

    /**
     * Hiển thị sơ đồ sắp xếp building trong khu phố
     * @param array $data 
     */
    private function _pagelet_street_view($data) {
        $street_building_config = $this->config->item('street_building_area', 'street');

        $buildings = array();
        foreach ($street_building_config as $index => $building) {
            $cell = $index * 2 + $data['offset'];
            $building_type = $this->building_type_library->get_by_cell($cell);

            $buildings[] = array(
                'class' => $building['class'],
                'id' => $building['id'],
                'image' => $building['image'][$data['offset'] - 1],
                'cell' => $cell,
                'name' => (empty($building_type) ? '' : (isset($building_type['name']) ? $building_type['name'] : lang('building_type_stadium')))
            );
        }
        $data['buildings'] = $buildings;
        $this->load->view('pagelet_street_view', $data);
    }

}