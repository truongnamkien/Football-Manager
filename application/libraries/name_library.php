<?php
require_once(APPPATH . 'libraries/abstract_library.php');

class Name_Library extends Abstract_Library {

    function __construct() {
        parent::__construct();
        $this->type = 'name';
        $this->cache_key = 'name';
        $this->key_map = array(
            'cache.object.info' => $this->cache_key . '$id',
            'cache.object.info.all' => $this->cache_key . 'all.' . $this->type,
            'cache.object.info.by.category' => $this->cache_key . '$category.' . $this->type,
        );
        parent::$CI->load->model(array('name_model'));
    }

    /**
     * Get all of the name by category
     * @param type $category
     * @param type $is_force
     * @return array 
     */
    public function get_all_by_category($category, $is_force = FALSE) {
        $key_all = $this->_get_key('cache.object.info.by.category', array('$category' => $category));
        if (!$is_force) {
            $cache_data = self::$CI->cache->get($key_all);
            if ($cache_data) {
                return $cache_data;
            }
        } else {
            self::$CI->cache->delete($key_all);
        }

        $objects = self::$CI->name_model->get_name($category);
        if ($objects['return_code'] == API_SUCCESS && !empty($objects['data'])) {
            $objects = $objects['data'];
            foreach ($objects as $object) {
                $id = $object['name_id'];
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
    
    /**
     * Get random name by category
     * @param type $category
     * @return type 
     */
    public function get_random_by_category($category) {
        $names = $this->get_all_by_category($category);
        $index = array_rand($names);
        return $names[$index]['name'];
    }

}
