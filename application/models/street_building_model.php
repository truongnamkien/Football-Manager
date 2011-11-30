<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street_Building_Model extends CI_Model {
    const MAX_LEVEL = 20;
    const LEVEL_PER_SECTION = 5;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('building_type_model');
    }

    public function create_street_building($building_data) {
        $data = array(
            'street_id' => $building_data['street_id'],
            'building_type_id' => $building_data['building_type_id'],
            'level' => ($building_data['type'] == Building_Type_Model::BUILDING_TYPE_MANAGEMENT ? 1 : 0)
        );
        if ($this->db->insert('street_building', $data)) {
            $street_building_id = $this->db->insert_id();
            if ($street_building_id > 0) {
                $building = array_merge($data, array('street_building_id' => $street_building_id));
                return $this->_ret(API_SUCCESS, $building);
            }
        }
        return $this->_ret(API_FAILED);
    }

    public function delete_street_building($building_type_id) {
        $this->db->delete('street_building', array('street_building_id' => $street_building_id));
    }

    public function update_street_building($street_building_id, $update_data) {
        $building = $this->get_street_building($street_building_id);
        if ($building['return_code'] != API_SUCCESS || empty($building['data'])) {
            return $this->_ret(API_FAILED);
        }
        $building = $building['data'];

        $this->db->trans_start();
        $this->db->where('street_building_id', $street_building_id)->update('street_building', $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->_ret(API_FAILED);
        } else {
            $this->db->trans_commit();
            $building = array_merge($building, $update_data);

            return $this->_ret(API_SUCCESS, $building);
        }
        return $this->_ret(API_FAILED);
    }

    public function get_street_building($street_building_id) {
        $query = $this->db->from('street_building')->where('street_building_id', $street_building_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $building = $query->row_array();

            if (!empty($building)) {
                return $this->_ret(API_SUCCESS, $building);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function get_all_building($street_id) {
        $query = $this->db->order_by('building_type_id', 'asc')
                ->where('street_id', $street_id)
                ->get('street_building');

        if (!empty($query) && $query->num_rows() > 0) {
            return $this->_ret(API_SUCCESS, $query->result_array());
        }

        return $this->_ret(API_FAILED);
    }

}
