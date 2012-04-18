<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Library hỗ trợ đăng nhập account
 */
class MY_Auth {

    private static $CI = NULL;
    private $identity_key = 'user:user_id';
    private $admin_identity_key = 'admin:admin_id';
    private $autologin_cookie_life = 5356800;
    private $autologin_cookie_name = 'fmatlg';
    private $admin_autologin_cookie_name = 'adfmatlg';

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('cookie');
        $this->CI->load->library(array('session', 'user_library', 'admin_library'));
        $this->CI->load->model(array('user_model', 'admin_model'));
    }

    /**
     * Bắt buộc phải login
     * @param type $is_admin
     * @return type boolean
     */
    public function login_required($is_admin = FALSE) {
        if (!$this->logged_in($is_admin)) {
            if (!$is_admin) {
                redirect('login');
            } else {
                redirect('admin_login');
            }
        }
        return TRUE;
    }

    /**
     * Thực hiện đăng nhập với một user nào đó.
     * @param type $email
     * @param type $password
     * @param type $remember
     * @param type $is_admin
     * @return type boolean
     */
    public function login($email, $password, $remember = FALSE, $is_admin = FALSE) {
        if (!$is_admin) {
            $user_info = $this->CI->user_model->get_where(array('email' => $email));
            $password = $this->CI->user_model->_hash_password($password);
        } else {
            $user_info = $this->CI->admin_model->get_where(array('username' => $email));
            $password = $this->CI->admin_model->_hash_password($password);
        }
        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            if ($password == $user_info['data']['password']) {
                if ($is_admin) {
                    $user_id = $user_info['data']['admin_id'];
                } else {
                    $user_id = $user_info['data']['user_id'];
                }
                $this->login_update($user_id, $remember, $is_admin);
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Update lại thông tin login của user trong session và cookie
     * @param type $user_id
     * @param type $remember
     * @param type $is_admin 
     * @author: kien.truong@miro.vn
     */
    private function login_update($user_id, $remember = FALSE, $is_admin = FALSE) {
        $keys = $this->get_session_cookie_key($is_admin);
        $this->CI->session->set_userdata($keys['session_key'], $user_id);

        if ($remember) {
            set_cookie(array(
                'name' => $keys['cookie_name'],
                'value' => $user_id,
                'expire' => $this->autologin_cookie_life,
            ));
        }
    }

    /**
     * Đăng xuất khỏi hệ thống.
     * @param type $is_admin 
     * @author: kien.truong@miro.vn
     */
    public function logout($is_admin = FALSE) {
        $keys = $this->get_session_cookie_key($is_admin);
        $this->CI->session->unset_userdata($keys['session_key']);
        delete_cookie($keys['cookie_name']);
    }

    /**
     * Kiểm tra xem login chưa ??
     * @param type $is_admin
     * @return type boolean
     */
    public function logged_in($is_admin = FALSE) {
        $keys = $this->get_session_cookie_key($is_admin);
        $user_id = $this->CI->session->userdata($keys['session_key']);
        if (!empty($user_id)) {
            return TRUE;
        }

        $user_id = get_cookie($keys['cookie_name'], TRUE);
        if (!empty($user_id)) {
            $this->login_update($user_id, TRUE, $is_admin = FALSE);
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Trả về user_id của user hiện tại.
     * @param type $is_admin
     * @return type string/int
     */
    public function get_user_id($is_admin = FALSE) {
        $keys = $this->get_session_cookie_key($is_admin);
        $user_id = $this->CI->session->userdata($keys['session_key']);
        if (!empty($user_id)) {
            return $user_id;
        }

        $user_id = get_cookie($keys['cookie_name'], TRUE);
        if (!empty($user_id)) {
            $this->login_update($user_id, TRUE, $is_admin = FALSE);
            return $user_id;
        }

        return FALSE;
    }

    /**
     * Tự động login nếu đã từng check remember_me
     * @param type $is_admin 
     * @author: kien.truong@miro.vn
     */
    public function auto_login($is_admin = FALSE) {
        $keys = $this->get_session_cookie_key($is_admin);
        if ($user_id = get_cookie($keys['cookie_name'], TRUE)) {
            if ($is_admin) {
                $user_info = $this->CI->admin_library->get($user_id);
            } else {
                $user_info = $this->CI->user_library->get($user_id);
            }
            if (!empty($user_info)) {
                $this->login_update($user_id, TRUE, $is_admin);
            }
        }
    }

    /**
     * Lấy session và cookie key
     * @param type $is_admin
     * @return type array
     * @author: kien.truong@miro.vn
     */
    private function get_session_cookie_key($is_admin = FALSE) {
        $ret = array();
        if ($is_admin) {
            $ret['session_key'] = $this->admin_identity_key;
            $ret['cookie_name'] = $this->admin_autologin_cookie_name;
        } else {
            $ret['session_key'] = $this->identity_key;
            $ret['cookie_name'] = $this->autologin_cookie_name;
        }
        return $ret;
    }

    /**
     * Get the street id of current user
     * @return type 
     */
    public function get_street_id() {
        $user_id = $this->get_user_id();
        if (empty($user_id)) {
            return FALSE;
        }
        $user = $this->CI->user_library->get($user_id);
        if (empty($user)) {
            return FALSE;
        }
        return $user['street_id'];
    }

}
