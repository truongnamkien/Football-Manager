<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Authen extends MY_Outer_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('user_model'));
        $this->load->library('user_library');
    }

    public function index() {
        $this->login();
    }

    public function register() {

        if ($this->my_auth->logged_in()) {
            redirect(site_url('street'));
        }
        $this->form_validation
                ->set_rules('display_name', 'lang:authen_display_name', 'trim|strip_tags|max_length[40]|required')
                ->set_rules('email', 'lang:authen_email', 'trim|required|valid_email|max_length[80]|unique[users.email]')
                ->set_rules('password', 'lang:authen_password', 'required|min_length[6]|max_length[32]')
                ->set_rules('password_confirm', 'lang:authen_password_confirm', 'required|matches[password]');

        if ($this->form_validation->run()) {
            $collect = $this->_collect(array(
                'display_name',
                'email',
                'password',
                    ));
            $user_info = $this->user_library->create($collect);

            //Dang ky thanh cong, goi email yeu cau verify             
            if (!empty($user_info)) {
                $this->my_auth->login($user_info['email'], $user_info['password']);
            }
            redirect(site_url('street'));
        }

        $this->load->view('frm_authen_register');
    }

    public function login() {
        if ($this->my_auth->logged_in()) {
            redirect(site_url('street'));
        }

        // set rule.
        $this->form_validation->set_rules('email', 'lang:authen_email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'lang:authen_password', 'trim|required|min_length[6]|max_length[32]');

        $data = array();
        if ($this->form_validation->run()) {

            // lấy dữ liệu từ form.
            $inputs = $this->_collect(array(
                'email',
                'password',
                'remember_me'
                    ));

            if ($this->my_auth->login($inputs['email'], $inputs['password'])) {
                // login ok, nếu có chọn remmeber thì set cookie cho lần sau.
                if ($inputs['remember_me'] == 1) {
                    ini_set('session.cookie_lifetime', 2592000);
                }
                redirect(site_url('street'));
            } else {
                $data['login_failed'] = array(
                    'title' => $this->lang->line('authen_login_fail'),
                    'messages' => array(
                        $this->lang->line('authen_login_fail_helper'),
                        $this->lang->line('authen_please_register')
                        . ' ' . anchor('authen/register', $this->lang->line('authen_register'), 'class="fwb"'),
                    ),
                );
            }
        }

        $this->load->view('frm_authen_login', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect(site_url('login'));
    }

}