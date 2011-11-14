<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Building_Type_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_building_type($building_type) {
        if ($this->db->insert('building_type', $building_type)) {
            $building_type_id = $this->db->insert_id();
            if ($building_type_id > 0) {
                $building_type['building_type_id'] = $building_type_id;
                return $this->_ret(API_SUCCESS, $building_type);
            }
            $this->db->trans_rollback();
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_building_type($building_type_id) {
        $this->db->delete('building_type', array('building_type_id' => $building_type_id));
    }

    public function update_building_type($building_type_id, $update_data) {
        $building_type = $this->get_building_type($building_type_id);

        if ($building_type['return_code'] == API_SUCCESS && !empty($building_type['data'])) {
            $this->db->trans_start();
            $this->db->where('building_type_id', $building_type_id)->update('building_type', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return $this->_ret(API_FAILED);
            } else {
                $this->db->trans_commit();

                $building_type = isset($building_type['data']) ? $building_type['data'] : array();
                $building_type = array_merge($building_type, $update_data);

                return $this->_ret(API_SUCCESS, $building_type);
            }
            return $this->_ret(API_FAILED);
        }
    }

    public function get_building_type($building_type_id) {
        $query = $this->db->from('building_type')->where('building_type_id', $building_type_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $building_type = $query->row_array();

            if (!empty($building_type_id)) {
                return $this->_ret(API_SUCCESS, $building_type_id);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function get_all_building_type() {
        $query = $this->db->order_by('building_type_id', 'desc')->get('building_type');

        if (!empty($query) && $query->num_rows() > 0) {
            return $this->_ret(API_SUCCESS, $query->result_array());
        }

        return $this->_ret(API_FAILED);
    }

}
