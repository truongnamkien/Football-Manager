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

    public function trigger_redirect() {
        $login_redirect = $_SERVER['REQUEST_URI'];
        $this->CI->session->set_userdata('login_redirect', $login_redirect);
    }

    public function login_required($is_admin = FALSE) {
        if (!$this->logged_in($is_admin)) {
            if (!$is_admin) {
                $this->trigger_redirect();
                redirect('login');
            } else {
                redirect('admin/admin');
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
            $user_info = $this->CI->admin_model->get_admin($email);
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
    public function get_user_id() {
        $user_id = FALSE;
        if ($this->CI->input->cookie($this->identity_key)) {
            $user_id = $this->CI->input->cookie($this->identity_key);
        } else if ($this->CI->session->userdata($this->identity_key)) {
            $user_id = $this->CI->session->userdata($this->identity_key);
        }
        return $user_id;
    }

    public function get_street_id() {
        $user_id = $this->get_user_id();
        if ($user_id == FALSE || $user_id == NULL) {
            return FALSE;
        }
        $user = User_Library::get($user_id);
        if ($user == FALSE || $user == NULL) {
            return FALSE;
        }
        return $user['street_id'];
    }

}
