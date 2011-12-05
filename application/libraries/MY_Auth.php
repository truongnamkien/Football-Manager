<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Auth {

    private static $CI = NULL;
    private $identity_key = 'user:id';
    private $admin_identity_key = 'admin:username';

    /**
     * Constructor for this class.
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('cookie');
        $this->CI->load->library(array('session', 'user_library'));
        $this->CI->load->model(array('user_model', 'admin_model'));
    }

    public function login_required($is_admin = FALSE) {
        if (!$this->logged_in($is_admin)) {
            if (!$is_admin) {
                redirect('login');
            } else {
                redirect('admin_login');
            }
        } else if ($is_admin) {
            $username = $this->get_user_id(TRUE);
            $admin_info = $this->CI->admin_model->get_by_username($username);
            if ($admin_info['return_code'] != API_SUCCESS || empty($admin_info['data'])) {
                $this->logout();
                redirect('admin_login');
            }
        }
        return TRUE;
    }

    /**
     * login
     * Thực hiện đăng nhập với một user nào đó.
     * @param string $username
     * @param string $password
     */
    public function login($email, $password, $is_admin = FALSE) {
        if (!$is_admin) {
            $user_info = $this->CI->user_model->get_user_by_email($email);
            $password = $this->CI->user_model->_hash_password($password);
        } else {
            $user_info = $this->CI->admin_model->get_by_username($email);
            $password = $this->CI->admin_model->_hash_password($password);
        }
        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            if ($password == $user_info['data']['password']) {
                if ($is_admin) {
                    $this->CI->session->set_userdata($this->admin_identity_key, $user_info['data']['username']);
                } else {
                    $this->CI->session->set_userdata($this->identity_key, $user_info['data']['user_id']);
                }
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * logout
     * Đăng xuất khỏi hệ thống.
     */
    public function logout() {
        $this->CI->session->sess_destroy();
    }

    /**
     * logged_in
     * Kiểm tra xem login chưa ??
     * @return bool
     */
    public function logged_in($is_admin = FALSE) {
        if ($is_admin) {
            $session = $this->CI->session->userdata($this->admin_identity_key);
        } else {
            $session = $this->CI->session->userdata($this->identity_key);
        }
        if (!empty($session)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * get_user_id
     * Trả về user_id của user hiện tại.
     */
    public function get_user_id($is_admin = FALSE) {
        $user_id = FALSE;
        if ($is_admin) {
            $key = $this->admin_identity_key;
        } else {
            $key = $this->identity_key;
        }

        if ($this->CI->input->cookie($key)) {
            $user_id = $this->CI->input->cookie($key);
        } else if ($this->CI->session->userdata($key)) {
            $user_id = $this->CI->session->userdata($key);
        }
        return $user_id;
    }

    public function get_street_id() {
        $user_id = $this->get_user_id();
        if ($user_id == FALSE || $user_id == NULL) {
            return FALSE;
        }
        $user = $this->CI->user_library->get($user_id);
        if ($user == FALSE || $user == NULL) {
            return FALSE;
        }
        return $user['street_id'];
    }

}
