<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Inner_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['type'] = 'admin';
        $this->load->model(array('admin_model'));
        $this->set_title(lang('manager_title') . ' - ' . lang('manager_' . $this->data['type']));
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

    public function edit() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect(site_url('admin_login'));
        }
        $admin_data = $this->_get_admin();

        $this->form_validation->CI = & $this;
        $this->form_validation->set_rules('role', 'lang:admin_role', 'required');
        $validate = $this->form_validation->run();

        if ($validate) {
            $update_data = array();

            foreach ($admin_data as $name => $val) {
                $new_val = $this->input->post($name);
                {
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

    public function remove() {
        $admin_id = $this->input->get_post('admin_id');
        $this->admin_model->delete_admin($admin_id);

        redirect('admin/admin');
    }

    protected function set_actions($id) {
        $actions = parent::set_actions($id);
        $path = 'admin/' . $this->data['type'] . '/';

        return $actions;
    }

    protected function set_validation_rules($action) {
        if ($action == 'create') {
            $rules = array(
                array('field' => 'display_name', 'rules' => 'trim|strip_tags|max_length[40]|required'),
                array('field' => 'username', 'rules' => 'trim|strip_tags|required|max_length[80]|unique[admin.username]'),
                array('field' => 'password', 'rules' => 'required|min_length[6]|max_length[32]'),
                array('field' => 'password_confirm', 'rules' => 'required|matches[password]'),
            );
        } else {
            $rules = array(
                array('field' => 'role', 'rules' => 'required'),
            );
        }
        return $rules;
    }
    protected function get_object($id = FALSE) {
        $object = parent::get_object($id);
        if($object == FALSE) {
            $object = array(
                'username' => '',
                'display_name' => '',
            );
        }

    }

}
