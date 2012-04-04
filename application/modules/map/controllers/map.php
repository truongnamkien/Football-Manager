<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Map extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('map_library', 'street_library', 'team_library', 'npc_library'));
        $this->load->model(array('street_model'));
        $this->load->language(array('map'));
    }

    public function index() {
        $street_id = $this->my_auth->get_street_id();
        $street = $this->street_library->get($street_id);
        $this->_display_map(array('street' => $street));
    }

    public function _display_map($info) {
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

        foreach ($data['streets'] as &$col) {
            foreach ($col as &$street_info) {
                $street_info['team'] = $this->team_library->get($street_info['team_id']);
                unset($street_info['team_id']);
                
                if ($street_info['street_type'] == Street_Model::STREET_TYPE_NPC) {
                    $npc = $this->npc_library->get_npc_with_street($street_info['street_id']);
                    $street_info['level'] = $npc['level'];
                }
            }
        }

        $this->load->view('pagelet_map_view', $data);
    }

}