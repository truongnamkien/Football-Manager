<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Asyncresponse {

    protected $data = array();

    public function __construct() {
        $this->data['status'] = 1;
    }

    public function set_error($err_id) {
        $this->data['error'] = $err_id;
    }

    public function set_error_summary($err_summary) {
        $this->data['errorSummary'] = $err_summary;
    }

    public function set_error_description($err_desc) {
        $this->data['errorDescription'] = $err_desc;
    }

    public function redirect($url) {
        echo json_encode(array(
            'redirect' => $url
        ));
        exit(0);
    }

    public function prepend($selector, $content, $context = FALSE) {
        $content = json_encode($content);
        if ($context !== FALSE)
            $this->data['onload'][] = "$('$selector',$context).prepend($content)";
        else
            $this->data['onload'][] = "$('$selector').prepend($content)";
        return $this;
    }

    public function append($selector, $content, $context = FALSE) {
        $content = json_encode($content);
        if ($context !== FALSE)
            $this->data['onload'][] = "$('$selector',$context).append($content)";
        else
            $this->data['onload'][] = "$('$selector').append($content)";
        return $this;
    }

    public function remove($selector, $context = FALSE) {
        if ($context !== FALSE)
            $this->data['onload'][] = "$('$selector',$context).remove()";
        else
            $this->data['onload'][] = "$('$selector').remove()";
        return $this;
    }

    public function attr($key, $val) {
        $current = array_pop($this->data['onload']);
        $this->data['onload'][] = $current . ".attr('$key', '$val')";
        return $this;
    }

    public function html($selector, $content, $context = FALSE) {
        $content = json_encode($content);
        if ($context != FALSE)
            $this->data['onload'][] = "$('$selector',$context).html($content)";
        else
            $this->data['onload'][] = "$('$selector').html($content)";
        return $this;
    }

    public function run($code) {
        $this->data['onload'][] = $code;
    }

    public function add_var($key, $val) {
        $this->data['payload'][$key] = $val;
    }

    public function send() {
        if (empty($this->data['onload']) && empty($this->data['payload']))
            $this->data['status'] = 0;

        if (!empty($this->data['onload'])) {
            $this->run("$('[placeholder], textarea').placeholder()");
        }

        echo json_encode($this->data);
        exit(0);
    }

}