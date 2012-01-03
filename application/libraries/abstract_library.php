<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Abstract_Library {

    protected static $CI = NULL;
    protected $cache_key;
    protected $type;
    protected $key_map;

    public function __construct() {
        self::$CI = & get_instance();
        self::$CI->load->driver('cache');
    }

    public function get($id, $is_force = FALSE, $callback = array()) {
        $key = $this->_get_key('cache.object.info', array('$id' => $id));
        if (!$is_force) {
            $cache_data = self::$CI->cache->get($key);
            if ($cache_data) {
                return $cache_data;
            }
        } else {
            self::$CI->cache->delete($key);
        }

        $model_name = $this->type . '_model';
        $object = self::$CI->$model_name->get($id);
        if ($object['return_code'] == API_SUCCESS && !empty($object['data'])) {
            $object = $object['data'];

            // after get
            if (!empty($callback) && isset($callback['after_get'])) {
                $function = $callback['after_get'];
                $object = $this->$function($object);
            }

            self::$CI->cache->save($key, $object);
            return $object;
        }
        return NULL;
    }

    public function create($data) {
        $model_name = $this->type . '_model';
        $object = self::$CI->$model_name->create($data);

        if ($object['return_code'] == API_SUCCESS && !empty($object['data'])) {
            $object = $object['data'];
            $id = $object[get_object_key($object, $this->type)];
            return $this->get($id, TRUE);
        }
        return NULL;
    }

    public function update($id, $data) {
        $model_name = $this->type . '_model';
        $object = self::$CI->$model_name->update($id, $data);
        if ($object['return_code'] == API_SUCCESS) {
            return $this->get($id, TRUE);
        }
        return NULL;
    }

    public function remove($id) {
        $model_name = $this->type . '_model';
        self::$CI->$model_name->delete($id);
        $key = $this->_get_key('cache.object.info', array('$id' => $id));
        $key_all = $this->_get_key('cache.object.info.all');
        self::$CI->cache->delete($key);
        self::$CI->cache->delete($key_all);
    }

    public function get_all($is_force = FALSE) {
        $key_all = $this->_get_key('cache.object.info.all');
        if (!$is_force) {
            $cache_data = self::$CI->cache->get($key_all);
            if ($cache_data) {
                return $cache_data;
            }
        } else {
            self::$CI->cache->delete($key_all);
        }

        $model_name = $this->type . '_model';
        $objects = self::$CI->$model_name->get_all();
        if ($objects['return_code'] == API_SUCCESS && !empty($objects['data'])) {
            $objects = $objects['data'];
            foreach ($objects as $object) {
                $id = $object[get_object_key($object, $this->type)];
                $key = $this->_get_key('cache.object.info', array('$id' => $id));
                $cache_info = self::$CI->cache->get($key);
                if ($cache_info != $object) {
                    self::$CI->cache->delete($key);
                    self::$CI->cache->save($key, $object);
                }
            }
        } else {
            $objects = array();
        }
        self::$CI->cache->save($key_all, $objects);
        return $objects;
    }

    public function count_all() {
        $model_name = $this->type . '_model';
        return self::$CI->$model_name->count_all();
    }

    protected function _get_key($key_name, array $variables = array()) {
        $key_map = $this->key_map;

        if (empty($key_map[$key_name])) {
            throw new Exception("Error: Key name is empty. Check your _get_key() call.");
        }

        $key = $key_map[$key_name];

        foreach ($variables as $n => $v) {
            $key = str_replace($n, $v, $key);
        }

        return $key;
    }

    protected function after_get_callback($object) {
        return $object;
    }

}
