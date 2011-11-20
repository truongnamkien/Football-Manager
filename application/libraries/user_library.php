<?php

class User_Library {

    private static $user_info = FALSE;
    private static $CI = NULL;
    private static $cache_key = 'user.info:';

    function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->model(array('user_model'));
        self::$CI->load->driver('cache');
        self::$CI->load->config('user', TRUE);
    }

    /**
     * Lấy thông tin của user bao gồm user_info
     */
    public static function get($user_id) {
        if (self::$user_info != FALSE && isset(self::$user_info[$user_id]) && !empty(self::$user_info[$user_id])) {
            return self::$user_info[$user_id];
        }
        $cache_data = self::$CI->cache->get(self::$cache_key . $user_id);
        if ($cache_data) {
            self::$user_info[$user_id] = $cache_data;
            return self::$user_info[$user_id];
        }

        $user = self::$CI->user_model->get_user($user_id);
        if ($user['return_code'] == API_SUCCESS && !empty($user['data'])) {
            $user = $user['data'];
            self::$CI->cache->save(self::$cache_key . $user_id, $user);
            self::$user_info[$user_id] = $user;
            return self::$user_info[$user_id];
        }
    }

    public static function create($data) {
        $street = Street_Library::create(FALSE, Street_Model::STREET_TYPE_PLAYER);
        $data['street_id'] = $street['street_id'];
        $data['balance'] = self::$CI->config->item('user_beginning_balance', 'user');

        $user = self::$CI->user_model->create_user($data);
        if ($user['return_code'] == API_SUCCESS && !empty($user['data'])) {
            $user = $user['data'];
            $user_id = $user['user_id'];
            self::$CI->cache->save(self::$cache_key . $user_id, $user);
            self::$user_info[$user_id] = $user;
            return self::$user_info[$user_id];
        }
        return FALSE;
    }

    public static function check_enough_balance($fee = 0) {
        $user = self::get(self::$CI->my_auth->get_user_id());
        return $user['balance'] >= $fee;
    }

    public static function update_balance($fee = 0) {
        $user_id = self::$CI->my_auth->get_user_id();
        $user = self::get($user_id);
        $balance = $user['balance'];
        $balance -= $fee;
        $ret = self::$CI->user_model->update_user($user_id, array('balance' => $balance));
        if ($ret['return_code'] == API_SUCCESS && !empty($ret['data']['balance'])) {
            $user = $ret['data'];
            self::$CI->cache->delete(self::$cache_key . $user_id);
            self::$CI->cache->save(self::$cache_key . $user_id, $user);
            self::$user_info[$user_id] = $user;
            return self::$user_info[$user_id];
        }
        return FALSE;
    }

}