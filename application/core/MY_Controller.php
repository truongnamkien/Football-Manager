<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public $_masterview_enabled = TRUE;
    public $_masterview = 'masterpage';
    public $_global_vars = array(
        'PAGE_TITLE' => '',
        'PAGE_CONTENT' => '',
    );

    public function __construct() {
        parent::__construct();
        // set header de prevent cache
        $this->output->set_header("Cache-Control: no-cache, must-revalidate");
        $this->output->set_header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
        $this->load->helper(array('html', 'MY_Date'));
        $this->_masterview_enabled = TRUE;
    }

    /**
     * Set title of the page
     * @param type $title 
     */
    public function set_title($title) {
        $this->_global_vars['PAGE_TITLE'] = $title;
    }

    /**
     * Enable the masterview of the page
     */
    public function enable_masterview() {
        $this->_masterview_enabled = TRUE;
    }

    /**
     * Disable the masterview of the page
     */
    public function disable_masterview() {
        $this->_masterview_enabled = FALSE;
    }

    /**
     * Collect the input data
     * @param type $params
     * @return type 
     */
    protected function _collect($params) {
        $this->load->helper('clear');
        if (is_array($params)) {
            foreach ($params as $item) {
                $result[$item] = $this->input->get_post($item, TRUE);
            }
        } else {
            $result = $this->input->get_post($params, TRUE);
        }

        return clear_my_ass($result);
    }

}

class MY_Ajax extends MY_Controller {

    protected $_data = array();

    public function __construct() {
        parent::__construct();
        $this->my_auth->auto_login();
        $this->my_auth->auto_login(TRUE);

        $this->_data['status'] = 0;
        $this->_data['onload'] = array();

        $this->load->library('MY_Asyncresponse');
        $this->response = $this->my_asyncresponse;
        $this->_masterview_enabled = FALSE;

        header("Content-type: text/html; charset=utf-8");
    }

    public function set_status($status) {
        $this->_data['status'] = $status;
    }

    /**
     * add_javascript_code
     * Thêm inline javascript code trong reponse trả về.
     * @param string $code
     */
    public function add_javascript_code($code) {
        $this->_data['onload'][] = $code;
    }

    /**
     * render_data
     * Render dữ liệu trả về cho client.
     */
    public function render_data() {
        echo json_encode($this->_data);
    }

    public function exception() {
        $this->load->library('MY_Dialog');
        $this->my_asyncresponse->add_var('_lock_ajax', 1);

        $this->my_dialog->set_dialog_type('alert');
        $this->my_dialog->set_title('Lỗi không xác định');
        $this->my_dialog->set_body('Hiện hệ thống đang bảo trì, xin vui lòng quay lại sau !');
        $this->my_dialog->set_buttons(array('ok'));
        $this->my_dialog->run(2);
    }

}

class MY_Outer_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->auto_login();
        $this->_masterview = 'admin_masterpage_not_logged';
    }

}

class MY_Inner_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->auto_login();
        $this->my_auth->login_required();
    }

}

class MY_Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->auto_login(TRUE);
        if ($this->my_auth->logged_in(TRUE)) {
            $this->_masterview = 'admin_masterpage_logged';
        } else {
            $this->_masterview = 'admin_masterpage_not_logged';
        }
        $this->load->language('admin');
        $this->set_title(lang('manager_title'));
    }

}

abstract class MY_Inner_Admin_Controller extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->login_required(TRUE);
        $this->data = array();
    }

    /**
     * Trang list
     */
    public function index() {
        $data['objects'] = $this->get_all_objects();
        $data['type'] = $this->data['type'];
        $data['total_rows'] = $this->count_all_objects();

        $data['mass_action_options'] = $this->set_mass_action_options();
        $data['main_nav'] = $this->_main_nav('index');

        $this->load->view('list_view', $data);
    }

    /**
     * Trang show
     * @param type $id 
     */
    public function show($id = FALSE) {
        $data['object'] = $this->get_object($id);
        $data['id'] = $id;
        $data['type'] = $this->data['type'];
        $data['main_nav'] = $this->_main_nav('show', $id);
        $this->load->view('show_view', $data);
    }

    public function create() {
        $this->create_update();
    }

    public function update($id) {
        $this->create_update($id);
    }

    public function remove($id) {
        $library_name = $this->get_library_name();
        $this->$library_name->remove($id);
        redirect(site_url('admin/' . $this->data['type']));
    }

    /**
     * Thực hiện action với số lượng lớn object
     */
    public function mass() {
        $params = $this->handle_post_inputs();
        $ids = explode(',', $params['ids']);
        $action = $params['mass_action_dropdown'];
        if ($action == 'remove') {
            $library_name = $this->get_library_name();
            foreach ($ids as $id) {
                $this->$library_name->remove($id);
            }
        }

        redirect(site_url('admin/' . $this->data['type']));
    }

    /**
     * Xử lý trang create/edit object
     * @param string $id
     */
    protected function create_update($id = FALSE) {
        $this->data['action'] = (empty($id) ? 'create' : 'update');
        if (!empty($id)) {
            $this->data['id'] = $id;
        }
        $this->data['form_data'] = $this->prepare_object($id);
        $validation_rules = $this->set_validation_rules($this->data['action']);
        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run() == FALSE) {
            if (empty($id)) {
                $id = '';
            }
            $this->data['main_nav'] = $this->_main_nav($this->data['action'], $id);
            $this->load->view('create_update_view', $this->data);
        } else {
            $params = $this->handle_post_inputs();
            $this->handle_create_update_object($params, $this->data['action'], $id);
        }
    }

    protected function set_mass_action_options() {
        $actions = array('select', 'remove');
        $options = array();
        foreach ($actions as $action) {
            $options[$action] = lang('admin_mass_' . $action);
        }
        return $options;
    }

    protected function set_actions($id) {
        $type = $this->data['type'];
        $path = 'admin/' . $type . '/';
        $actions['update'] = anchor($path . 'update/' . $id, lang($type . '_update'));
        $actions['show'] = anchor($path . 'show/' . $id, lang($type . '_show'));
        $actions['remove'] = anchor($path . 'remove/' . $id, lang($type . '_remove'), array('class' => 'remove', 'onclick' => 'return confirm(\'' . lang($this->data['type'] . '_remove_confirm') . '\');'));
        return $actions;
    }

    protected function get_all_objects() {
        $library_name = $this->get_library_name();
        $objects = $this->$library_name->get_all();

        $result = array();
        foreach ($objects as $obj) {
            $id = $obj[get_object_key($obj, $this->data['type'])];
            $result[] = array_merge($obj, array('actions' => $this->set_actions($id)));
        }
        return $result;
    }

    protected function get_object($id = FALSE) {
        if ($id === FALSE || !is_numeric($id)) {
            show_404();
        } else {
            $library_name = $this->get_library_name();
            $object = $this->$library_name->get($id);
            if (empty($object)) {
                show_404();
            }
        }
        return $object;
    }

    protected function count_all_objects() {
        $library_name = $this->get_library_name();
        return $this->$library_name->count_all();
    }

    protected function get_library_name() {
        return $this->data['type'] . '_library';
    }

    protected function handle_post_inputs() {
        $params = array();
        foreach ($this->input->post() as $key => $value) {
            $params[$key] = $value;
        }
        return $params;
    }

    protected function handle_create_update_object($params, $action, $id = FALSE) {
        unset($params['submit']);
        $library_name = $this->get_library_name();

        if (!empty($id)) {
            $this->$library_name->$action($id, $params);
            redirect(site_url('admin/' . $this->data['type'] . '/show/' . $id));
        } else {
            $this->$library_name->$action($params);
            redirect(site_url('admin/' . $this->data['type']));
        }
    }

    protected function _main_nav($page = 'index', $id = '') {
        $nav_list = array();
        $type = $this->data['type'];
        if ($page == 'index') {
            $nav_list[$type . '_create'] = site_url('admin/' . $type . '/create');
        } else {
            $nav_list['back_list'] = site_url('admin/' . $type);
        }
        if ($page == 'show') {
            $nav_list[$type . '_update'] = site_url('admin/' . $type . '/update/' . $id);
            $nav_list[$type . '_remove'] = site_url('admin/' . $type . '/remove/' . $id);
        }
        if ($page == 'update') {
            $nav_list[$type . '_show'] = site_url('admin/' . $type . '/show/' . $id);
        }

        return $nav_list;
    }

    protected function parse_object_field($object, $specific_input = array()) {
        $result = array();
        foreach ($object as $key => $val) {
            $label = form_label(lang($this->data['type'] . '_' . $key), $key);
            $value = array('name' => $key, 'value' => $val);

            if (!empty($specific_input) && isset($specific_input[$key]) && isset($specific_input[$key]['input'])) {
                switch ($specific_input[$key]['input']) {
                    case 'textarea':
                        $value = form_textarea($value);
                        break;
                    case 'dropdown':
                        $value = form_dropdown($value['name'], $specific_input[$key]['options'], $value['value']);
                        break;
                    case 'upload':
                        $value = form_upload($value['name'], '');
                        break;
                    case 'label':
                        $value = form_label($value['value'], $value['name']);
                        break;
                    case 'image':
                        $value = img($specific_input[$key]['src']);
                        break;
                    case 'none':
                        $value = $value['value'];
                        break;
                    case 'password':
                        $value = form_password($value['name']);
                        break;
                    case 'radio':
                        $value = '';
                        foreach ($specific_input[$key]['options'] as $radio_val => $radio_display) {
                            $value .= '<div class="fLeft ma5 tac border rounded pa5">';
                            $value .= form_radio($key, $radio_val, ($val !== FALSE && $val !== '' && $val == $radio_val), 'id="radio_' . $key . '_' . $radio_val . '"');
                            $value .= '<div class="clear">' . form_label($radio_display, 'radio_' . $key . '_' . $radio_val) . '</div>';
                            $value .= '</div>';
                        }
                        break;
                }
            } else {
                $value = form_input($value, '', 'autocomplete="off"');
            }
            $result[] = array($label => $value);
        }
        return $result;
    }

    abstract protected function set_validation_rules($action);

    abstract protected function prepare_object($id = FALSE);
}

