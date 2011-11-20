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
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect(site_url('admin_login'));
        }
        $admins = $this->admin_model->get_all_admin();
        $data = array();
        if ($admins['return_code'] == API_SUCCESS && !empty($admins['data'])) {
            $data['admins'] = $admins['data'];
        }
        $this->load->view('admins/frm_admin_list_view', $data);
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
        $this->load->view('admins/frm_admin_login', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect(site_url('admin'));
    }

    public function register() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect(site_url('admin_login'));
        }

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
                redirect(site_url('admin'));
            }
        }

        $this->load->view('admins/frm_admin_register');
    }

    public function show() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect(site_url('admin_login'));
        }

        $admin_data = $this->_get_admin();
        $this->load->view('admins/frm_admin_show_view', $admin_data);
    }

    public function edit() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect(site_url('admin_login'));
        }
        $admin_data = $this->_get_admin();

        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        $this->form_validation->set_rules('role', 'lang:admin_role', 'required');
        $validate = $this->form_validation->run();

        if ($validate) {
            $update_data = array();

            foreach ($admin_data as $name => $val) {
                $new_val = $this->input->post($name); {
                    if ($new_val != $val) {
                        $update_data[$name] = $new_val;
                        $admin_data[$name] = $new_val;
                    }
                }
            }
            if (!empty($update_data)) {
                $this->admin_model->update_admin($admin_data['admin_id'], $update_data);
            }
            redirect(site_url('admin/admin/show?admin_id=' . $admin_data['admin_id']));
        }
        $admin_data['roles'] = $this->_get_roles();
        $this->load->view('admins/frm_admin_edit', $admin_data);
    }

    private function _get_admin() {
        if (FALSE == ($id = $this->input->get_post('admin_id'))) {
            show_404();
        }
        $admin = $this->admin_model->get_admin($id);

        if ($admin['return_code'] != API_SUCCESS || empty($admin['data'])) {
            show_404();
        } else {
            $admin = $admin['data'];
        }

        return $admin;
    }

    private function _get_roles() {
        return array(Admin_Model::ADMIN_ROLE_ADMIN, Admin_Model::ADMIN_ROLE_MODERATOR);
    }

}
