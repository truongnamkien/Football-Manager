<?php

class User_Library {

    public static $instance = NULL;
    private $user_info = FALSE;
    private $CI = NULL;
    private $cache_key = 'user.info:';

    function __construct() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        self::$instance->CI = & get_instance();
        self::$instance->CI->load->model(array('user_model'));
        self::$instance->CI->load->driver('cache');
        self::$instance->CI->load->config('user', TRUE);
    }

    /**
     * Lấy thông tin của user bao gồm user_info
     */
    public static function get($user_id) {
        if (self::$instance->user_info != FALSE && isset(self::$instance->user_info[$user_id]) && !empty(self::$instance->user_info[$user_id])) {
            return self::$instance->user_info[$user_id];
        }
        $cache_data = self::$instance->CI->cache->get(self::$instance->cache_key . $user_id);
        if ($cache_data) {
            self::$instance->user_info[$user_id] = $cache_data;
            return self::$instance->user_info[$user_id];
        }

        $user = self::$instance->CI->user_model->get_user($user_id);
        if ($user['return_code'] == API_SUCCESS && !empty($user['data'])) {
            $user = $user['data'];
            self::$instance->CI->cache->save(self::$instance->cache_key . $user_id, $user);
            self::$instance->user_info[$user_id] = $user;
            return self::$instance->user_info[$user_id];
        }
    }

    public static function create($data) {
        $street = Street_Library::create(FALSE, Street_Model::STREET_TYPE_PLAYER);
        $data['street_id'] = $street['street_id'];
        $data['balance'] = self::$CI->config->item('user_beginning_balance', 'user');

        $user = self::$instance->CI->user_model->create_user($data);
        if ($user['return_code'] == API_SUCCESS && !empty($user['data'])) {
            $user = $user['data'];
            $user_id = $user['user_id'];
            self::$instance->CI->cache->save(self::$instance->cache_key . $user_id, $user);
            self::$instance->user_info[$user_id] = $user;
            return self::$instance->user_info[$user_id];
        }
        return FALSE;
    }

    public static function check_enough_balance($fee = 0) {
        $user = self::get(self::$instance->CI->my_auth->get_user_id());
        return $user['balance'] >= $fee;
    }

    public static function update_balance($fee = 0) {
        $user_id = self::$instance->CI->my_auth->get_user_id();
        $user = self::get($user_id);
        $balance = $user['balance'];
        $balance -= $fee;
        $ret = self::$instance->CI->user_model->update_user($user_id, array('balance' => $balance));
        if ($ret['return_code'] == API_SUCCESS && !empty($ret['data']['balance'])) {
            $user = $ret['data'];
            self::$instance->CI->cache->delete(self::$instance->cache_key . $user_id);
            self::$instance->CI->cache->save(self::$instance->cache_key . $user_id, $user);
            self::$instance->user_info[$user_id] = $user;
            return self::$instance->user_info[$user_id];
        }
        return FALSE;
    }

}