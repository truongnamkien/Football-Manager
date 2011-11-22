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
    }

    public function set_title($title) {
        $this->_global_vars['TX_PAGE_TITLE'] = $title;
    }

    public function enable_masterview() {
        $this->_masterview_enabled = TRUE;
    }

    public function disable_masterview() {
        $this->_masterview_enabled = FALSE;
    }

    /**
     *
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

        $this->_data['status'] = 0;
        $this->_data['onload'] = array();

        $this->load->library('MY_Asyncresponse');
        $this->response = $this->my_asyncresponse;

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
        $this->_masterview_enabled = TRUE;
    }

}

class MY_Inner_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_masterview_enabled = TRUE;
        $this->my_auth->login_required();
    }

}

class MY_Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_masterview_enabled = TRUE;
        if ($this->my_auth->logged_in(TRUE)) {
            $this->_masterview = 'admin_masterpage_logged';
        } else {
            $this->_masterview = 'admin_masterpage_not_logged';
        }
        $this->load->language('admin');
    }

}

abstract class MY_Inner_Admin_Controller extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->my_auth->login_required(TRUE);
        $this->data = array();
    }

    public function index() {
        $data['objects'] = $this->get_all_objects();
        $data['type'] = $this->data['type'];
        $data['total_rows'] = $this->count_all_objects();

        $data['mass_action_options'] = $this->set_mass_action_options();

        $this->load->view('list_view', $data);
    }

    public function show($id = FALSE) {
        $data['object'] = $this->get_object($id);
        $data['id'] = $id;
        $data['type'] = $this->data['type'];
        $this->load->view('show_view', $data);
    }

    public function create() {
        $this->data['form_data'] = $this->get_object($id); // abstract
        $this->data['id'] = $id;

        $validation_rules = $this->set_validation_rules(); // abstract
        $this->form_validation->set_rules($validation_rules);


        if ($id == FALSE || !is_numeric($id)) {
            show_404();
        }
        $data['object'] = $this->get_object($id);
        $data['id'] = $id;
        $data['type'] = $this->data['type'];
        $this->load->view('show_view', $data);
    }

    protected function set_mass_action_options() {
        return array(
            'select' => 'Choose an action...',
            'delete' => 'Delete',
        );
    }

    protected function set_actions($id) {
        $type = $this->data['type'];
        $path = 'admin/' . $type . '/';
        $actions = anchor($path . 'edit/' . $id, lang($type . '_edit'));
        $actions .= ' | ' . anchor($path . 'show/' . $id, lang($type . '_show'));
        $actions .= ' | ' . anchor($path . 'remove/' . $id, lang($type . '_remove'), 'class="remove"');
        return $actions;
    }

    protected function get_all_objects() {
        $model_name = $this->get_model_name();
        $method_name = 'get_all_' . $this->data['type'];

        $result = array();
        $objects = $this->$model_name->$method_name();
        if ($objects['return_code'] == API_SUCCESS && !empty($objects['data'])) {
            $objects = $objects['data'];
            foreach ($objects as $obj) {
                $id = $obj[key($obj)];
                $result[] = array_merge($obj, array('actions' => $this->set_actions($id)));
            }
        }
        return $result;
    }

    protected function get_object($id = FALSE) {
        $object = FALSE;
        if ($id !== FALSE) {
            if (!is_numeric($id)) {
                show_404();
            }
            $model_name = $this->get_model_name();
            $method_name = 'get_' . $this->data['type'];
            $object = $this->$model_name->$method_name($id);
            if ($object['return_code'] != API_SUCCESS || empty($object['data'])) {
                show_404();
            }
            $object = $object['data'];
        }
        return $object;
    }

    protected function count_all_objects() {
        $model_name = $this->get_model_name();
        $method_name = 'count_all_' . $this->data['type'];
        return $this->$model_name->$method_name();
    }

    protected function get_model_name() {
        return $this->data['type'] . '_model';
    }

    abstract protected function set_validation_rules($action);
}

