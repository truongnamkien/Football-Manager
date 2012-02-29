<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class Admin_Model extends Abstract_Model {

    /**
     * $salt_length
     * Độ dài của salt cho mật khẩu. Salt là một chuỗi bí mật, được
     * thêm vào mật khẩu của admin, nhằm tăng tính bảo mật.
     * @var int
     */
    private $salt_length = 10;

    const ADMIN_ROLE_ADMIN = 'admin';
    const ADMIN_ROLE_MODERATOR = 'moderator';

    public function __construct() {
        parent::__construct();
        $this->type = 'admin';
        $this->database = 'admin';
    }

    public function create($data) {
        $salt = FALSE;

        $data['password'] = $this->_hash_password($data['password'], $salt);
        if (!isset($admin_info['role'])) {
            $data['role'] = self::ADMIN_ROLE_MODERATOR;
        }
        unset($data['admin_id']);
        unset($data['password_confirm']);
        return parent::create($data);
    }

    public function delete($admin) {
        if (is_array($admin)) {
            $admin_id = $admin['admin_id'];
        } else if (is_numeric($admin)) {
            $admin_id = $admin;
        }
        if (isset($admin_id)) {
            parent::delete($admin_id);
        } else {
            parent::delete_where(array('username' => $admin));
        }
    }

    public function get_by_username($username) {
        return $this->get_where(array('username' => $username));
    }

    public function change_password($id, $old_pass, $new_pass) {
        $old_salt = FALSE;
        $old = $this->_hash_password($old_pass, $old_salt);

        if ($old_pass === $new_pass) {
            return $this->_ret(API_SUCCESS);
        }
        return $this->update($id, array('password' => $new_pass), array('password' => $old));
    }

    public function update($id, $update_data, $filter = array()) {
        unset($update_data['username']);
        unset($update_data['admin_id']);
        unset($update_data['password_confirm']);
        if (isset($update_data['password'])) {
            /* salt la key ngau nhien co do dai co dinh duoc gan vo password */
            $salt = FALSE;
            $update_data['password'] = $this->_hash_password($update_data['password'], $salt);
        }
        return parent::update($id, $update_data, $filter);
    }

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

    protected function check_existed($data) {
        $admin_info = $this->get_by_username($data['username']);
        if ($admin_info['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
