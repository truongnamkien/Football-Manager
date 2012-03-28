<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

abstract class Abstract_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create object
     * @param type $data
     * @return type 
     */
    public function create($data) {
        $ret = $this->check_existed($data);
        unset($data[$this->type . '_id']);

        if ($ret['return_code'] == API_SUCCESS && empty($ret['data'])) {
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

    /**
     * Delete object with id
     * @param type $id 
     */
    public function delete($id) {
        $this->delete_where(array($this->type . '_id' => $id));
    }

    /**
     * Delete object with condition
     * @param type $filter
     */
    public function delete_where($filter) {
        $this->db->where($filter)->delete($this->database);
    }

    /**
     * Get object with id
     * @param type $id
     * @return type 
     */
    public function get($id) {
        return $this->get_where(array($this->type . '_id' => $id));
    }

    /**
     * Get object with condition, and sort
     * @param type $filter
     * @param string $sort_by
     * @param string $order
     * @return type 
     */
    public function get_where($filter, $sort_by = FALSE, $order = 'asc') {
        if (empty($sort_by)) {
            $sort_by = $this->type . '_id';
        }
        if ($order != 'asc' && $order != 'desc') {
            $order = 'asc';
        }

        $query = $this->db->from($this->database)
                ->order_by($sort_by, $order)
                ->where($filter)
                ->get();
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

    /**
     * Update object with id
     * @param type $id
     * @param type $update_data
     * @param type $filter
     * @return type 
     */
    public function update($id, $update_data, $filter = array()) {
        $filter = array_merge($filter, array($this->type . '_id' => $id));
        return $this->update_where($update_data, $filter);
    }

    /**
     * Update objects with condition
     * @param type $update_data
     * @param type $filter
     * @return type 
     */
    public function update_where($update_data, $filter) {
        unset($update_data[$this->type . '_id']);

        $this->db->trans_start();
        $this->db->where($filter)->update($this->database, $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->_ret(API_FAILED);
        } else {
            $this->db->trans_commit();
            return $this->get_where($filter);
        }
    }

    /**
     * Get all objects and sort
     * @param string $sort_by
     * @param string $order
     * @return type 
     */
    public function get_all($sort_by = FALSE, $order = 'asc') {
        if (empty($sort_by)) {
            $sort_by = $this->type . '_id';
        }
        if ($order != 'asc' && $order != 'desc') {
            $order = 'asc';
        }

        $query = $this->db
                ->order_by($sort_by, $order)
                ->get($this->database);

        if (!empty($query) && $query->num_rows() > 0) {
            $data = $query->result_array();
            return $this->_ret(API_SUCCESS, $data);
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * Return number of objects in database
     * @return type 
     */
    public function count_all() {
        return $this->db->count_all($this->database);
    }

    abstract protected function check_existed($info);
}