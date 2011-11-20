<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Cooldown_Model extends CI_Model {
    const COOLDOWN_TYPE_BUILDING = 'building';
    const COOLDOWN_TYPE_RESEARCH = 'research';
    const COOLDOWN_TYPE_MATCHING = 'marching';

    const MAX_COOLDOWN_SLOT_BUILDING = 3;
    const MAX_COOLDOWN_SLOT_RESEARCHING = 1;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_cooldown($cooldown) {
        if ($this->db->insert('cooldown', $cooldown)) {
            $cooldown_id = $this->db->insert_id();
            if ($cooldown_id > 0) {
                $cooldown['cooldown_id'] = $cooldown_id;
                return $this->_ret(API_SUCCESS, $cooldown);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_cooldown($cooldown_id) {
        $this->db->delete('cooldown', array('cooldown_id' => $cooldown_id));
    }

    public function get_cooldown($cooldown_id) {
        $query = $this->db->from('cooldown')->where('cooldown_id', $cooldown_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $cooldown = $query->row_array();

            if (!empty($cooldown)) {
                return $this->_ret(API_SUCCESS, $cooldown);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function get_cooldown_by_street($street_id) {
        $query = $this->db->from('cooldown')->where('street_id', $street_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $cooldowns = $query->result_array();

            if (!empty($cooldowns)) {
                return $this->_ret(API_SUCCESS, $cooldowns);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function update_cooldown($cooldown_id, $update_data) {
        $this->db->trans_start();
        $cooldown = $this->get_cooldown($cooldown_id);
        if ($cooldown['return_code'] == API_SUCCESS && !empty($cooldown['data'])) {
            $cooldown = $cooldown['data'];
        } else {
            return $this->_ret(API_FAILED);
        }

        $this->db->where('cooldown_id', $cooldown_id)->update('cooldown', $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            /* unknown error */
            return $this->_ret(API_FAILED);
        } else {
            $this->db->trans_commit();

            $cooldown = array_merge($cooldown, $update_data);

            return $this->_ret(API_SUCCESS, $cooldown);
        }
        return $this->_ret(API_FAILED);
    }

}
