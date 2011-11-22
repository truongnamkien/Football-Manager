<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Authen extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $this->form_validation->set_rules('username', 'lang:authen_username', 'trim|strip_tags|required');
        $this->form_validation->set_rules('password', 'lang:authen_password', 'trim|required|min_length[6]|max_length[32]');

        $data = array();
        if ($this->form_validation->run()) {
            $inputs = $this->_collect(array('username', 'password'));
            if ($this->my_auth->login($inputs['username'], $inputs['password'], TRUE)) {
                redirect(site_url('admin'));
            } else {
                $data['login_failed'] = array(
                    'title' => $this->lang->line('authen_login_fail'),
                    'messages' => array($this->lang->line('authen_login_fail_helper'),
                        $this->lang->line('authen_please_register')),
                );
            }
        }
        $this->load->view('authen/frm_admin_login', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect(site_url('admin_login'));
    }

}
