<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_Model extends CI_Model {

    /**
     * $salt_length
     * Độ dài của salt cho mật khẩu. Salt là một chuỗi bí mật, được
     * thêm vào mật khẩu của admin, nhằm tăng tính bảo mật.
     * @var int
     */
    private $salt_length = 10;

    /**
     * $store_salt
     * Có sử dụng salt hay không ?.
     * @var boolean
     */
    private $store_salt = FALSE;

    const ADMIN_ROLE_ADMIN = 0;
    const ADMIN_ROLE_MODERATOR = 0;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * create_admin
     * Tao admin theo thong tin $admininfo.
     * Sample $admin_info array:
     *
     * @param array $admininfo
     * @return $admin_info
     */
    public function create_admin($admin_info) {
        $ret = $this->check_username_exists($admin_info['username']);

        if (($ret['return_code'] == API_SUCCESS) && $ret['data'] === FALSE) {
            /* salt la key ngau nhien co do dai co dinh duoc gan vo password */
            $salt = $this->store_salt === TRUE ? $this->_salt() : FALSE;

            $admin_info['password'] = $this->_hash_password($admin_info['password'], $salt);
            if (!isset($admin_info['role'])) {
                $admin_info['role'] = self::ADMIN_ROLE_MODERATOR;
            }

            if ($this->db->insert('admin', $admin_info)) {
                $admin_id = $this->db->insert_id();
                if ($admin_id > 0) {
                    $admin_info['admin_id'] = $admin_id;
                    return $this->_ret(API_SUCCESS, $admin_info);
                }
            }
            $this->db->trans_rollback();
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_admin($admin) {
        if(is_array($admin)) {
            $admin_id = $admin['admin_id'];
        } else if (is_numeric($admin)) {
            $admin_id = $admin;
        }
        if(isset($admin_id)) {
            $this->db->delete('admin', array('admin_id' => $admin_id));
        } else {
            $this->db->delete('admin', array('username' => $admin));
        }
    }

    /**
     * get_admin
     * Tra ve thong tin admin.
     * @param int $admin_id
     * @return array
     */
    public function get_admin($admin) {
        if (is_numeric($admin)) {
            $query = $this->db->from('admin')->where('admin_id', $admin)->get();
        } else {
            $query = $this->db->from('admin')->where('username', $admin)->get();
        }
        
        if (!empty($query) && $query->num_rows() > 0) {
            $admin_info = $query->row_array();

            if (!empty($admin_info)) {
                return $this->_ret(API_SUCCESS, $admin_info);
            }
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * change_password
     * Doi mat khau.
     * @param string $old_pass
     * @param string $new_pass
     */
    public function change_password($admin, $old_pass, $new_pass) {
        $admin_info = $this->get_admin($admin);

        if ($admin_info['return_code'] == API_SUCCESS && !empty($admin_info['data'])) {
            $db_password = $admin_info['data']['password'];

            $old_salt = $this->store_salt === TRUE ? $admin_info['data']['salt'] : FALSE;

            /* neu old pass chinh la hash cua password cu trong db
             * thi ko can hash pass lai nua.
             * vi day la call cua recovery password
             */
            if ($old_pass == $db_password) {
                $old = $db_password;
            } else {
                $old = $this->_hash_password($old_pass, $old_salt);
            }

            $new_salt = $this->store_salt === TRUE ? $this->_salt() : FALSE;
            $new = $this->_hash_password($new_pass, $new_salt);

            if ($new === $old) {
                return $this->_ret(API_SUCCESS);
            }

            if ($db_password === $old) {
                $this->db->trans_start();
                $update_data = array(
                    'password' => $new
                );
                $this->db->update('admin', $update_data, array('admin_id' => $admin_info['data']['admin_id']));

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    /* unknown error */
                    return $this->_ret(API_FAILED);
                } else {
                    $this->db->trans_commit();

                    $admin_info = isset($admin_info['data']) ? $admin_info['data'] : NULL;
                    $admin_info = array_merge($admin_info, $update_data);

                    return $this->_ret(API_SUCCESS, $admin_info);
                }
            } else {
                return $this->_ret(API_FAILED);
            }
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * update_admin
     * Cap nhat thong tin admin.
     * @param array $admin_info
     */
    public function update_admin($admin, $update_data) {
        $admin_info = $this->get_admin($admin);

        if ($admin_info['return_code'] == API_SUCCESS && !empty($admin_info['data'])) {
            unset($update_data['username']);
            unset($update_data['admin_id']);

            if (isset($update_data['password'])) {
                /* salt la key ngau nhien co do dai co dinh duoc gan vo password */
                $salt = $this->store_salt === TRUE ? $admin_info['data']['salt'] : FALSE;
                $update_data['password'] = $this->_hash_password($update_data['password'], $salt);
            }

            $this->db->trans_start();
            $this->db->where('admin_id', $admin_info['data']['admin_id'])->update('admin', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                /* unknown error */
                return $this->_ret(API_FAILED);
            } else {
                $this->db->trans_commit();

                $admin_info = isset($admin_info['data']) ? $admin_info['data'] : array();
                $admin_info = array_merge($admin_info, $update_data);

                return $this->_ret(API_SUCCESS, $admin_info);
            }
            return $this->_ret(API_FAILED);
        }
    }

    /**
     * check_username_exists
     * Kiem tra username da ton tai chua.
     * @param $username
     * @return bool
     */
    private function check_username_exists($username) {
        $admin_info = $this->get_admin($username);
        if ($admin_info['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

    /**
     * _salt
     * Tra ve activation key cua admin.
     */
    private function _salt() {
        return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
    }

    /**
     * _hash_password
     * Hash password cau admin.
     * @param $password
     * @param $salt
     */
    public function _hash_password($password, $salt = FALSE) {
        if (empty($password)) {
            return FALSE;
        }

        if ($salt) {
            return sha1($password . $salt);
        } else {
            return md5($password);
        }
    }

}
