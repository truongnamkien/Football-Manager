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

    protected $_require_logged_in = TRUE;

    public function __construct() {
        parent::__construct();
        $this->_masterview_enabled = TRUE;
        $this->_masterview = 'admin_masterpage';
        if ($this->_require_logged_in) {
            $this->my_auth->login_required(TRUE);
        }
        $this->load->language('admin');
    }

}

