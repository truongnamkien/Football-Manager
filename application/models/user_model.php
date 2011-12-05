<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require_once(APPPATH . 'models/abstract_model.php');

class User_Model extends Abstract_Model {

    /**
     * $salt_length
     * Độ dài của salt cho mật khẩu. Salt là một chuỗi bí mật, được
     * thêm vào mật khẩu của user, nhằm tăng tính bảo mật.
     * @var int
     */
    private $salt_length = 10;

    const USER_STATUS_INACTIVE = 'inactive';
    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_RECOVERY_PASSWORD = 'recovery';

    public function __construct() {
        parent::__construct();
        $this->type = 'user';
        $this->database = 'users';
    }

    public function create_user($data) {
        $salt = FALSE;

        $data['password'] = $this->_hash_password($data['password'], $salt);
        if (!isset($data['user_status'])) {
            $data['user_status'] = self::USER_STATUS_ACTIVE;
        }
        unset($data['password_confirm']);
        return parent::create($data);
    }

    public function change_password($user_id, $old_pass, $new_pass) {
        $old_salt = FALSE;
        $old = $this->_hash_password($old_pass, $old_salt);

        if ($old_pass === $new_pass) {
            return $this->_ret(API_SUCCESS);
        }
        return $this->update($id, array('password' => $new_pass), array('password' => $old));
    }

    public function update($id, $update_data, $filter = array()) {
        unset($update_data['email']);
        unset($update_data['password_confirm']);
        if (isset($update_data['password'])) {
            $salt = FALSE;
            $update_data['password'] = $this->_hash_password($update_data['password'], $salt);
        }
        return parent::update($id, $update_data, $filter);
    }

    public function get_user_by_email($email) {
        return $this->get_where(array('email' => $email));
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
        $user_info = $this->get_user_by_email($data['email']);
        if ($user_info['return_code'] == API_SUCCESS) {
            return $this->_ret(API_SUCCESS, TRUE);
        }

        return $this->_ret(API_SUCCESS, FALSE);
    }

}
