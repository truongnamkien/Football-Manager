<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class NPC_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_npc($npc) {
        $ret = $this->get_npc_with_street($npc);

        if (($ret['return_code'] == API_SUCCESS) && $ret['data'] === FALSE) {
            unset($npc['npc_id']);
            if ($this->db->insert('npc', $npc)) {
                $npc_id = $this->db->insert_id();
                if ($npc_id > 0) {
                    $npc['npc_id'] = $npc_id;
                    return $this->_ret(API_SUCCESS, $npc);
                }
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_npc($npc_id) {
        $this->db->delete('npc', array('npc_id' => $npc_id));
    }

    public function get_npc($npc_id) {
        $query = $this->db->from('npc')->where('npc_id', $npc_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $npc_info = $query->row_array();

            if (!empty($npc_info)) {
                return $this->_ret(API_SUCCESS, $npc_info);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function update_npc($npc_id, $update_data) {
        $npc_info = $this->get_npc($npc_id);

        if ($npc_info['return_code'] == API_SUCCESS && !empty($npc_info['data'])) {
            unset($update_data['npc_id']);

            $this->db->trans_start();
            $this->db->where('npc_id', $npc_id)->update('npc', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                /* unknown error */
                return $this->_ret(API_FAILED);
            } else {
                $this->db->trans_commit();

                $npc_info = isset($npc_info['data']) ? $npc_info['data'] : array();
                $npc_info = array_merge($npc_info, $update_data);

                return $this->_ret(API_SUCCESS, $npc_info);
            }
            return $this->_ret(API_FAILED);
        }
    }

    public function get_npc_with_street($steet_id) {
        $npc_info = $this->db->from('npc')->where(array('steet_id' => $steet_id))->limit(1)->get();
        $npc_info = $npc_info->row_array();

        if (!empty($npc_info)) {
            return $this->_ret(API_SUCCESS, $npc_info);
        }

        return $this->_ret(API_FAILED);
    }

    public function get_all_npc() {
        $query = $this->db->order_by('npc_id', 'asc')->get('npc');
        if (!empty($query) && $query->num_rows() > 0) {
            return $this->_ret(API_SUCCESS, $query->result_array());
        }

        return $this->_ret(API_FAILED);
    }

    public function count_all_npc() {
        return $this->db->count_all('npc');
    }

}

