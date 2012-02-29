<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Abstract_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create(array $data) {
        $ret = $this->check_existed($data);
        unset($data[$this->type . '_id']);

        if ($ret['return_code'] == API_SUCCESS && $ret['data'] == FALSE) {
            if ($this->db->insert($this->database, $data)) {
                $id = $this->db->insert_id();
                if ($id > 0) {
                    $data[$this->type . '_id'] = $id;
                    return $this->_ret(API_SUCCESS, $data);
                }
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function delete($id) {
        $this->delete_where(array($this->type . '_id' => $id));
    }
    
    public function delete_where(array $filter) {
        $this->db->delete($this->database, $filter);
    }

    public function get($id) {
        return $this->get_where(array($this->type . '_id' => $id));
    }

    public function get_where(array $filter) {
        $query = $this->db->from($this->database)->where($filter)->get();
        if (!empty($query)) {
            if ($query->num_rows() == 1) {
                $data = $query->row_array();
            } else {
                $data = $query->result_array();
            }

            if (!empty($data)) {
                return $this->_ret(API_SUCCESS, $data);
            }
        }
        return $this->_ret(API_FAILED);
    }

    public function update($id, array $update_data, array $filter = array()) {
        $filter = array_merge($filter, array($this->type . '_id' => $id));
        return $this->update_where($update_data, $filter);
    }

    public function update_where(array $update_data, array $filter) {
        unset($update_data[$this->type . '_id']);

        $this->db->trans_start();
        $this->db->where($filter)->update($this->database, $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->_ret(API_FAILED);
        } else {
            $this->db->trans_commit();
            $data = array_merge($data, $update_data);
            return $this->_ret(API_SUCCESS, $data);
        }
    }

    public function get_all(array $filter = array()) {
        if (empty($filter)) {
            $query = $this->db->order_by($this->type . '_id', 'asc')->get($this->database);
        } else {
            $query = $this->db->order_by($this->type . '_id', 'asc')->where($filter)->get($this->database);
        }

        if (!empty($query) && $query->num_rows() > 0) {
            $data = $query->result_array();
            return $this->_ret(API_SUCCESS, $data);
        }

        return $this->_ret(API_FAILED);
    }

    public function count_all() {
        return $this->db->count_all($this->database);
    }

    abstract protected function check_existed($info);
}