<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    /**
     * $salt_length
     * Độ dài của salt cho mật khẩu. Salt là một chuỗi bí mật, được
     * thêm vào mật khẩu của user, nhằm tăng tính bảo mật.
     * @var int
     */
    private $salt_length = 10;

    /**
     * $store_salt
     * Có sử dụng salt hay không ?.
     * @var boolean
     */
    private $store_salt = FALSE;

    const USER_STATUS_INACTIVE = 'inactive';
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_RECOVERY_PASSWORD = 'recovery';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * create_user
     * Tao user theo thong tin $userinfo.
     * Sample $user_info array:
     *
     * @param array $userinfo
     * @return $user_info
     */
    public function create_user($user_info) {
        $ret = $this->check_email_exists($user_info['email']);

        if (($ret['return_code'] == API_SUCCESS) && $ret['data'] === FALSE) {
            /* salt la key ngau nhien co do dai co dinh duoc gan vo password */
            $salt = $this->store_salt === TRUE ? $this->_salt() : FALSE;

            $user_info['password'] = $this->_hash_password($user_info['password'], $salt);
            if (!isset($user_info['user_status'])) {
                $user_info['user_status'] = self::USER_STATUS_INACTIVE;
            }

            if ($this->db->insert('users', $user_info)) {
                $user_id = $this->db->insert_id();
                if ($user_id > 0) {
                    $user_info['user_id'] = $user_id;
                    return $this->_ret(API_SUCCESS, $user_info);
                }
            }
        }

        return $this->_ret(API_FAILED);
    }

    public function delete_user($user_id) {
        $this->db->delete('users', array('user_id' => $user_id));
    }

    /**
     * get_user
     * Tra ve thong tin user.
     * @param int $userid
     * @return array
     */
    public function get_user($user_id) {
        $query = $this->db->from('users')->where('user_id', $user_id)->get();

        if (!empty($query) && $query->num_rows() > 0) {
            $user_info = $query->row_array();

            if (!empty($user_info)) {
                return $this->_ret(API_SUCCESS, $user_info);
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
    public function change_password($user_id, $old_pass, $new_pass) {
        $user_info = $this->get_user($user_id);

        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            $db_password = $user_info['data']['password'];

            $old_salt = $this->store_salt === TRUE ? $user_info['data']['salt'] : FALSE;

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
                    'password' => $new,
                    'user_status' => self::USER_STATUS_ACTIVE,
                );
                $this->db->update('users', $update_data, array('user_id' => $user_id));

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    /* unknown error */
                    return $this->_ret(API_FAILED);
                } else {
                    $this->db->trans_commit();

                    $user_info = isset($user_info['data']) ? $user_info['data'] : NULL;
                    $user_info = array_merge($user_info, $update_data);

                    return $this->_ret(API_SUCCESS, $user_info);
                }
            } else {
                return $this->_ret(API_FAILED);
            }
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * update_user
     * Cap nhat thong tin user.
     * @param array $user_info
     */
    public function update_user($user_id, $update_data) {
        $user_info = $this->get_user($user_id);

        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            unset($update_data['email']);
            unset($update_data['user_id']);

            if (isset($update_data['password'])) {
                /* salt la key ngau nhien co do dai co dinh duoc gan vo password */
                $salt = $this->store_salt === TRUE ? $user_info['data']['salt'] : FALSE;
                $update_data['password'] = $this->_hash_password($update_data['password'], $salt);
            }

            $this->db->trans_start();
            $this->db->where('user_id', $user_id)->update('users', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                /* unknown error */
                return $this->_ret(API_FAILED);
            } else {
                $this->db->trans_commit();

                $user_info = isset($user_info['data']) ? $user_info['data'] : array();
                $user_info = array_merge($user_info, $update_data);

                return $this->_ret(API_SUCCESS, $user_info);
            }
            return $this->_ret(API_FAILED);
        }
    }

    /**
     * get_user_by_email
     * Lay thong tin user qua email.
     * @param string $email
     * @return array
     */
    public function get_user_by_email($email) {
        $user_info = $this->db->from('users')->where(array('email' => $email))->limit(1)->get();

        $user_info = $user_info->row_array();

        if (!empty($user_info)) {
            return $this->_ret(API_SUCCESS, $user_info);
        }

        return $this->_ret(API_FAILED);
    }

    /**
     * check_email_exists
     * Kiem tra email da ton tai chua.
     * @param $email
     * @return bool
     */
    private function check_email_exists($email) {
        $user_info = $this->get_user_by_email($email);
        if ($user_info['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

    /**
     * _salt
     * Tra ve activation key cua user.
     */
    private function _salt() {
        return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
    }

    /**
     * _hash_password
     * Hash password cau user.
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

    public function get_all_user() {
        $query = $this->db->order_by('user_id', 'asc')->get('users');
        if (!empty($query) && $query->num_rows() > 0) {
            return $this->_ret(API_SUCCESS, $query->result_array());
        }

        return $this->_ret(API_FAILED);
    }

    public function count_all_user() {
        return $this->db->count_all('users');
    }

}
