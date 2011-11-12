<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Auth {

    private static $CI = NULL;
    private static $user_info = FALSE;
    private $identity_key = 'user:id';

    /**
     * Constructor for this class.
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('cookie');
        $this->CI->load->library('session');
        $this->CI->load->model(array('user_model'));
    }

    /**
     * Dùng cho các modules không yêu cầu login
     * Gọi hàm này nếu các modules muốn login xong về lại đúng trang trước đó.
     * @author quocnguyen
     */
    public function trigger_redirect() {
        $login_redirect = $_SERVER['REQUEST_URI'];
        $this->CI->session->set_userdata('login_redirect', $login_redirect);
    }

    public function login_required($is_mobile = FALSE) {
        if (!$this->logged_in()) {
            $this->trigger_redirect();
            redirect('login');
        }
        return TRUE;
    }

    /**
     * login
     * Thực hiện đăng nhập với một user nào đó.
     * @param string $username
     * @param string $password
     */
    public function login($email, $password) {
        $user_info = $this->CI->user_model->get_user_by_email($email);

        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            $password = $this->CI->user_model->_hash_password($password);
            if ($password == $user_info['data']['password']) {
                $this->CI->session->set_userdata($this->identity_migrate_key, $ret['data']['userid']);
                $this->CI->session->set_userdata($this->username_key, $ret['data']['username']);
                $this->CI->session->set_userdata($this->password_key, $password);
                $this->user_info = $user_info['data'];
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

        delete_cookie($this->password_key);
        delete_cookie($this->username_key);
        delete_cookie($this->email_key);
        $this->CI->load->library('app');
        $this->CI->app->app_destroy();
    }

    /**
     * logged_in
     * Kiểm tra xem login chưa ??
     * @return bool
     */
    public function logged_in() {
        $session = $this->CI->session->userdata($this->identity_key);

        if (!empty($session)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Lấy thông tin cơ bản của user.
     * 
     * @param string $field
     * @param int $user_id
     * @param type $user
     * @return mixed 
     */
    public function get_user_info() {
        // dang nao cung phai lay, tien thi lay luon
        if ($this->user_info === FALSE) {
            $user_info = $this->CI->user_model->get_user($this->get_user_id());

            if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
                self::$user_info = $user_info['data'];
            } else {
                self::$user_info = FALSE;
            }
        }

        return self::$user_info;
    }

    /**
     * get_user_id
     * Trả về user_id của user hiện tại.
     */
    public function get_user_id() {
        $user_id = FALSE;
            if ($this->CI->input->cookie($this->identity_key))
                $user_id = $this->CI->input->cookie($this->identity_key);
            else if ($this->CI->session->userdata($this->identity_key))
                $user_id = $this->CI->session->userdata($this->identity_key);

        return $user_id;
    }
}
