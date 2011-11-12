<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * chùi mông đít mấy kí tự khoảng trắng.
 */
if ( ! function_exists('clear_my_ass')) 
{
	function clear_my_ass($params)
	{
		$ci =& get_instance();
		if(is_array($params))
		{
			foreach($params as $index => $value)
			{
				$params[$index] = clear_my_ass($value);
			}			
		}
		else
		{
			$params = preg_replace('/\s+/u', ' ', trim($params));
			$params = nl2br(htmlspecialchars($params));
		}

		return $params;
	}
}