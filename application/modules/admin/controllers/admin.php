<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Admin_Controller {

    public function __construct() {
        $this->_require_logged_in = FALSE;
        parent::__construct();

        $this->load->library(array('form_validation'));
        $this->load->model(array('admin_model'));
    }

    public function index() {
        $this->my_auth->login_required(TRUE);
    }

    public function login() {
        $this->form_validation->set_rules('username', 'lang:authen_username', 'trim|strip_tags|required');
        $this->form_validation->set_rules('password', 'lang:authen_password', 'trim|required|min_length[6]|max_length[32]');

        $data = array();
        if ($this->form_validation->run()) {
            $inputs = $this->_collect(array('username', 'password'));
            if ($this->my_auth->login($inputs['username'], $inputs['password'], TRUE)) {
                redirect('/admin');
            } else {
                $data['login_failed'] = array(
                    'title' => $this->lang->line('authen_login_fail'),
                    'messages' => array($this->lang->line('authen_login_fail_helper'),
                        $this->lang->line('authen_please_register')),
                );
            }
        }
        $this->load->view('frm_admin_login', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect('admin');
    }

    public function register() {
        $this->my_auth->login_required(TRUE);

        $this->form_validation
                ->set_rules('display_name', 'lang:authen_display_name', 'trim|strip_tags|max_length[40]|required')
                ->set_rules('username', 'lang:authen_username', 'trim|strip_tags|required|max_length[80]|unique[admin.username]')
                ->set_rules('password', 'lang:authen_password', 'required|min_length[6]|max_length[32]')
                ->set_rules('password_confirm', 'lang:authen_password_confirm', 'required|matches[password]');

        if ($this->form_validation->run()) {
            $collect = $this->_collect(array(
                'display_name',
                'username',
                'password',
                    ));
            $user_info = $this->admin_model->create_admin($collect);

            if ($user_info['return_code'] === API_SUCCESS) {
                redirect('admin');
            }
        }

        $this->load->view('frm_admin_register');
    }
}
