<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Dialog
{
	private $ci = null;
	private $data = array();
	
	public function __construct()
	{
		$this->ci = & get_instance();
	}
	
	public function set_title($title) 
	{
		$this->data['title'] = $title;
	}
	
	public function set_body($body)
	{
		$this->data['body'] = $body;
	}

	public function set_dialog_type($type)
	{
	    $this->data['type'] = $type;
	}
	
	public function set_post_uri($uri, $showDialog) 
	{
	    $this->data['postURI'] = array($uri, $showDialog);
	}
	
	public function set_class_name($className) 
	{
	    $this->data['className'] = $className;
	}
	
	public function set_buttons($buttons) 
	{
		$this->data['buttons'] = $buttons;
	}
	
        public function set_store_history($value) 
        {
            $this->data['storeHistory'] = $value;
        }
        
        public function set_go_history($index) 
        {
            $this->data['goHistory'] = $index;
        }
        
	public function run($error = FALSE) 
	{
		if ($error != FALSE) {
            $this->ci->my_asyncresponse->set_error($error);
        }

        $this->ci->my_asyncresponse->add_var('__dialog', $this->data);	
		
		$this->data = array();
		$this->ci->my_asyncresponse->send();	
	}
	
	public function confirm() 
	{
		if (1 != ($confirmed = $this->ci->input->get_post('confirmed'))) {
			// TODO dinh nghia cac error code
			$this->ci->my_asyncresponse->set_error(1);
			$this->ci->my_asyncresponse->add_var('__dialog', $this->data);
			$this->data = array();	
			$this->ci->my_asyncresponse->send();
			return FALSE;
		}
		$this->data = array();
		return TRUE;
	}
}