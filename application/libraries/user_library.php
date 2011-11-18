<?php

class User_Library {

    public static $instance = NULL;
    private $full_info = FALSE;
    private static $CI = null;

    function __construct() {

        self::$CI = & get_instance();
        self::$CI->load->model(array('user_model', 'street_model'));
        self::$CI->load->library('street_library');
        self::$CI->load->config('user', TRUE);
    }

    /**
     * Lấy thông tin của user bao gồm user_info và street_info
     */
    public static function get($user_id = NULL) {
        self::current();

        $user_info = self::$CI->user_model->get_user($user_id);
        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            $user_info = $user_info['data'];

            Street_Library::get($user_info['street_id']);
            $user_info['street'] = Street_Library::execute();
        } else {
            $user_info = array();
        }
        self::$instance->full_info = $user_info;
        return self::$instance;
    }

    public static function create($data) {
        $street_info = Street_Library::create(FALSE, Street_Model::STREET_TYPE_PLAYER);
        $data['street_id'] = $street_info['street_id'];
        $data['balance'] = self::$CI->config->item('user_beginning_balance', 'user');

        $user_info = self::$CI->user_model->create_user($data);
        if ($user_info['return_code'] == API_SUCCESS && !empty($user_info['data'])) {
            $user_info = $user_info['data'];
        } else {
            $user_info = array();
        }

        return $user_info;
    }

    public static function check_enough_balance($fee = 0) {
        $user_info = self::execute();
        return $user_info['balance'] >= $fee;
    }

    public static function update_balance($fee = 0) {
        $user_info = self::execute();
        $balance = $user_info['balance'];
        $balance -= $fee;
        $ret = self::$CI->user_model->update_user($user_info['user_id'], array('balance' => $balance));
        if($ret['return_code'] == API_SUCCESS && !empty($ret['data']['balance'])) {
            $user_info['balance'] = $ret['data']['balance'];
            self::$instance->full_info = $user_info;
        }
        return $ret;
    }

    /**
     * return the new instance.
     */
    public static function factory() {
        self::$instance = new self;
        return self::$instance;
    }

    /**
     * return the current.
     */
    public static function current() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function execute() {
        self::current();

        $result = array();
        if (self::$instance->full_info != FALSE) {
            $result = self::$instance->full_info;
        }

        return $result;
    }

}