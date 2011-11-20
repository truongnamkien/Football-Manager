<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model(array('user_model'));
        $this->load->language(array('user'));
    }

    public function index() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $users = $this->user_model->get_all_users();
        $data = array();
        if ($users['return_code'] == API_SUCCESS && !empty($users['data'])) {
            $data['users'] = $users['data'];
        }

        $this->load->view('users/frm_users_list_view', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect('admin');
    }

    public function show() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $user = $this->_get_user();
        $this->load->view('users/frm_user_show_view', $user);
    }

    public function edit() {
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $user_data = $this->_get_user();
        $validate = $this->_validate_user();

        if ($validate) {
            $update_data = array();

            foreach ($user_data as $name => $val) {
                $new_val = $this->input->post($name); {
                    if ($new_val != $val) {
                        $update_data[$name] = $new_val;
                        $user_data[$name] = $new_val;
                    }
                }
            }
            if (!empty($update_data)) {
                $user_data = $this->user_model->update_user($user_data['user_id'], $update_data);
            }
            redirect('admin/users/show?user_id=' . $user_data['data']['user_id']);
        }
        $this->load->view('users/frm_user_edit', $user_data);
    }

    private function _get_user() {
        if (FALSE == ($id = $this->input->get_post('user_id'))) {
            show_404();
        }
        $user = $this->user_model->get_user($id);

        if ($user['return_code'] != API_SUCCESS || empty($user['data'])) {
            show_404();
        } else {
            $user = $user['data'];
        }

        return $user;
    }

    private function _validate_user() {
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        $this->form_validation
                ->set_rules('display_name', 'lang:authen_display_name', 'trim|strip_tags|max_length[40]|required')
                ->set_rules('user_status', 'lang:building_type_fee', 'numeric|required');

        return $this->form_validation->run();
    }
}
