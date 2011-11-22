<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model(array('user_model'));
        $this->load->language(array('user'));
        $this->load->config('admins', TRUE);
    }

    public function index() {
//        $admins = $this->admin_model->get_all_admin();
//        $data = array();
//        if ($admins['return_code'] == API_SUCCESS && !empty($admins['data'])) {
//            $data['admins'] = $admins['data'];
//        }
//        $data['roles'] = $this->config->item('admin_roles', 'admins');
//
//        $this->load->view('admins/admin_list_view', $data);
        
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $users = $this->user_model->get_all_users();
        $data = array();
        if ($users['return_code'] == API_SUCCESS && !empty($users['data'])) {
            $data['users'] = $users['data'];
        }
        
        
        $data['status'] = $this->config->item('user_status', 'admins');

        $this->load->view('users/frm_users_list_view', $data);

    }

    public function login() {
//        $this->form_validation->set_rules('username', 'lang:authen_username', 'trim|strip_tags|required');
//        $this->form_validation->set_rules('password', 'lang:authen_password', 'trim|required|min_length[6]|max_length[32]');
//
//        $data = array();
//        if ($this->form_validation->run()) {
//            $inputs = $this->_collect(array('username', 'password'));
//            if ($this->my_auth->login($inputs['username'], $inputs['password'], TRUE)) {
//                redirect('/admin');
//            } else {
//                $data['login_failed'] = array(
//                    'title' => $this->lang->line('authen_login_fail'),
//                    'messages' => array($this->lang->line('authen_login_fail_helper'),
//                        $this->lang->line('authen_please_register')),
//                );
//            }
//        }
//        $this->load->view('admins/frm_admin_login', $data);
    }

    public function logout() {
        $this->my_auth->logout();
        redirect('admin');
    }

    public function register() {
//        if (!$this->my_auth->logged_in(TRUE)) {
//            redirect('admin_login');
//        }
//
//        $this->form_validation
//                ->set_rules('display_name', 'lang:authen_display_name', 'trim|strip_tags|max_length[40]|required')
//                ->set_rules('username', 'lang:authen_username', 'trim|strip_tags|required|max_length[80]|unique[admin.username]')
//                ->set_rules('password', 'lang:authen_password', 'required|min_length[6]|max_length[32]')
//                ->set_rules('password_confirm', 'lang:authen_password_confirm', 'required|matches[password]');
//
//        if ($this->form_validation->run()) {
//            $collect = $this->_collect(array(
//                'display_name',
//                'username',
//                'password',
//                    ));
//            $user_info = $this->admin_model->create_admin($collect);
//
//            if ($user_info['return_code'] === API_SUCCESS) {
//                redirect('admin');
//            }
//        }
//
//        $this->load->view('admins/frm_admin_register');
    }
    
    public function show(){
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $user = $this->_get_user();
        $user['status'] = $this->config->item('user_status', 'admins');
        $this->load->view('users/frm_user_show_view', $user);
    }
    
    public function edit(){
        if (!$this->my_auth->logged_in(TRUE)) {
            redirect('admin_login');
        }
        $user_data = $this->_get_user();
        $validate = $this->_validate_user();
        
        if($validate)
        {
            $update_data = array();
            
            foreach ($user_data as $name => $val) {
                $new_val = $this->input->post($name);
                {
                    if($new_val != $val )
                    {
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
        $user_data['status'] = $this->config->item('user_status', 'admins');
//        echo "<pre>";
//        print_r($user_data);
//        echo "</pre>";
//        die;
        $this->load->view('users/frm_user_edit', $user_data);

    }
    
    private function _get_user() {
        if (FALSE == ($id = $this->input->get_post('user_id'))){
            show_404();
        }
        $user= $this->user_model->get_user($id);
        
        if($user['return_code'] != API_SUCCESS || empty($user['data'])){
            show_404();
        }
        else
        {
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
    public function remove() {
        $user_id = $this->input->get_post('user_id');
        $this->user_model->delete_user($user_id);

        redirect('admin/users');
    }
    
    public function reset_password()
    {
        $user_id = $this->_get_user();
        $new_password = 123456;
        $result = $this->user_model->change_password($user_id['user_id'], $user_id['password'],$new_password);
        if($result['return_code'] == API_SUCCESS)
        {
            redirect('admin/users');
        }
        else
        {
            show_404();
        }
    }
}