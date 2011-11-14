<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street_Building_Model extends CI_Model {
    const MAX_LEVEL = 20;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_street_building($street_id, $building_types) {
        $this->db->trans_start();
        $buildings = array();
        foreach ($building_types as $type) {
            $data = array(
                'street_id' => $street_id,
                'building_type_id' => $type['building_type_id'],
                'level' => ($type['building_type_id'] == 1 ? 1 : 0)
            );
            if ($this->db->insert('street_building', $data)) {
                $street_building_id = $this->db->insert_id();
                if ($street_building_id > 0) {
                    $buildings[] = array_merge($data, array('street_building_id' => $street_building_id));
                } else {
                    $this->db->trans_rollback();
                    return $this->_ret(API_FAILED);
                }
            } else {
                $this->db->trans_rollback();
                return $this->_ret(API_FAILED);
            }
        }
        return $this->_ret(API_SUCCESS, $buildings);
    }

    public function delete_street_building($building_type_id) {
        $this->db->delete('street_building', array('street_building_id' => $street_building_id));
    }

    public function upgrade_street_building($street_building_id) {
        $building = $this->get_street_building($street_building_id);
        if ($building['return_code'] == API_SUCCESS && !empty($building['data'])) {
            $level = $building['data']['level'];
            if ($level < self::MAX_LEVEL) {
                $data = array('level' => ($level + 1));
                return $this->update_street_building($building, $data);
            }
        }
        return $this->_ret(API_FAILED);
    }

    public function downgrade_street_building($street_building_id) {
        $building = $this->get_street_building($street_building_id);
        if ($building['return_code'] == API_SUCCESS && !empty($building['data'])) {
            $level = $building['data']['level'];
            if ($level > 0) {
                $data = array('level' => ($level - 1));
                return $this->update_street_building($building, $data);
            }
        }
        return $this->_ret(API_FAILED);
    }

    private function update_street_building($building, $update_data) {
        $this->db->trans_start();
        $this->db->where('street_building_id', $building['street_building_id'])->update('street_building', $update_data);

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
