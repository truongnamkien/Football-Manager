<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Street_Model extends CI_Model {
    const MAP_WIDTH = 100;
    const MAP_HEIGHT = 100;

    const AREA_WIDTH = 10;
    const AREA_HEIGHT = 10;

    const STREET_TYPE_PLAYER = 'player';
    const STREET_TYPE_NPC = 'npc';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * create_user
     * Tao street theo thong tin $street_info.
     *
     * @param array $street_info
     * @return $street_info
     */
    public function create_street($street_info) {
        if ($this->db->insert('streets', $street_info)) {
            $street_id = $this->db->insert_id();
            if ($street_id > 0) {
                $street_info['street_id'] = $street_id;
                return $this->_ret(API_SUCCESS, $street_info);
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_street($street_id) {
        $this->db->delete('streets', array('street_id' => $street_id));
    }

    /**
     * update_user
     * Cap nhat thong tin user.
     * @param array $user_info
     */
    public function update_street($street_id, $update_data) {
        $street = $this->get_street($street_id);

        if ($street['return_code'] == API_SUCCESS && !empty($street['data'])) {
            unset($update_data['x_coor']);
            unset($update_data['y_coor']);

            $this->db->trans_start();
            $this->db->where('street_id', $street_id)->update('streets', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                /* unknown error */
                return $this->_ret(API_FAILED);
            } else {
                $this->db->trans_commit();

                $street = isset($street['data']) ? $street['data'] : array();
                $street = array_merge($street, $update_data);

                return $this->_ret(API_SUCCESS, $street);
            }
            return $this->_ret(API_FAILED);
        }
    }

    /**
     * get_street
     * Tra ve thong tin street.
     * @param int $street_id
     * @return array
     */
    public function get_street($street_id) {
        $query = $this->db->from('streets')->where('street_id', $street_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $street = $query->row_array();

            if (!empty($street)) {
                return $this->_ret(API_SUCCESS, $street);
            }
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * get_street_by_area
     * Tra ve thong tin nhung street nam trong khu vuc
     * @param int $area
     * @return array
     */
    public function get_street_by_area($min_x, $max_x, $min_y, $max_y) {
        $query = $this->db->where('x_coor >=', $min_x)
                ->where('x_coor <=', $max_x)
                ->where('y_coor >=', $min_y)
                ->where('y_coor <=', $max_y)
                ->get('streets');

        if ($query && $query->num_rows() > 0) {
            $streets = $query->result_array();
            if (!empty($streets)) {
                $result = array();
                foreach ($streets as $street) {
                    $x_coor = $street['x_coor'] % self::AREA_WIDTH;
                    $y_coor = $street['y_coor'] % self::AREA_HEIGHT;
                    $result[$x_coor][$y_coor] = $street;
                }

                return $this->_ret(API_SUCCESS, $result);
            }
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * Lay thong tin street qua toa do.
     * @param string $x_coor, $y_coor
     * @return array
     */
    public function get_street_by_coordinate($x_coor, $y_coor) {
        $query = $this->db->from('streets')->where(array('x_coor' => $x_coor, 'y_coor' => $y_coor))->limit(1)->get();

        $street = $query->row_array();

        if (!empty($street)) {
            return $this->_ret(API_SUCCESS, $street);
        }

        return $this->_ret(API_FAILED);
    }

}
