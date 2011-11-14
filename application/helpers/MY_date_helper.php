<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('week_day'))
{	
	function week_day($datetime)
    {
		$CI = & get_instance();
		$CI->load->language('datetime');
        
        $date = date('D', $datetime);
        foreach (lang('datetime_week_day') as $eday => $vday)
        {
            $date = str_replace($eday, $vday, $date);
        }
        
        return $date;        
    }
}

if( ! function_exists('display_date'))
{	
	function display_date($datetime)
	{
		$CI = & get_instance();
		$CI->load->language('datetime');

		$datetime = array(
			'day' => date('d', $datetime),
			'month' => date('m', $datetime),
			'year' => date('Y', $datetime) == date('Y', now()) ? '' : date('Y', $datetime),
			'hour' => date('H', $datetime),
			'minute' => date('i', $datetime),
		);
		$time = lang('datetime_time_dropdown');
		$datetime['time'] = $time[$datetime['hour'] * 60 + $datetime['minute']];

		return lang_key('datetime_dateformat_full', '', $datetime);
	}
}

if( ! function_exists('relative_date'))
{	
	function relative_date($start_time)
	{
		$now = mktime(23, 59, 59);

		//$start_time = mktime(23, 59, 59, date('n', $start_time), date('j', $start_time), date('Y', $start_time));
		//$duration = $start_time - $now;

		//$minutes = floor($duration/60); /*tinh theo phut*/
        //$hours = floor($minutes/60); /*tinh theo gio*/
        //$day = floor($hours / 24);
        $range_start = mktime(0, 0, 0);
        $range_end = mktime(23, 59, 59); 

        //var_dump(date('h:i', strtotime("+1 day"))); die();

        if ($start_time >= $range_start && $start_time <= $range_end)
        	return 'Hôm nay';
        else if ($start_time > $range_end) { // ngay hom nay tro ve sau
    		if ($start_time <= strtotime("tomorrow 23:59:59")) // ngay mai
    			return 'Ngày mai';
    		else if ($start_time <= strtotime("sunday 23:59:59")) 
    			return 'Tuần này';
    		else if ($start_time <= strtotime("last day of this month 23:59:59"))
    			return 'Tháng này';
        } else if ($start_time < $range_start) {
        	if ($start_time >= strtotime("yesterday 00:00:00")) // ngay mai
    			return 'Hôm qua';
    		else if ($start_time >= strtotime("last monday 00:00:00")) 
    			return 'Tuần này';
    		else if ($start_time >= strtotime("first day of this month 23:59:59"))
    			return 'Tháng này';
        }
        
        if (date('Y', $now) == date('Y', $start_time)) return mdate('Tháng %m', $start_time);
		else return mdate('Tháng %m, %Y', $start_time);
 	}
}

if( ! function_exists('relative_time'))
{	
	function relative_time($datetime, $show_time = TRUE)
	{
		$now = now();		
	
		if (date('Y', $now) != date('Y', $datetime))
		{
			$datestring = "Ngày %d tháng %m %Y lúc %h:%i %a";						
			return mdate($datestring, $datetime);       
		}
		
        $duration = $now - $datetime; /*khoang cach*/        
        $minutes = floor($duration/60); /*tinh theo phut*/
        $hours = floor($minutes/60); /*tinh theo gio*/
        $day = floor($hours / 24);
        
		if ( $minutes < 1) { // < hon 1 phut            
            return "Một vài giây trước";
        }	        		
        
		if( $hours < 1) { // < hon 1 giờ
            if( $minutes == 1 )  return "Khoảng một phút trước";
            else return $minutes . " phút trước";                                   
        }                
        
        if ($day < 1) 
        {
	        if( $hours == 1 ) return "Khoảng một giờ trước";
	        else return $hours . " giờ trước";
        }

        if ($day == 1)
        {
        	$datestring = "Hôm qua";
			if ($show_time)
				$datestring .= " lúc %h:%i %a";
        	return mdate($datestring, $datetime);
        }
        	
        $datestring = "Ngày %d tháng %m";	
		if ($show_time)
			$datestring .= " lúc %h:%i %a";					
		return mdate($datestring, $datetime);       
	}
}


if( ! function_exists('distant_time'))
{	
	function distant_time($time)
	{
        $seconds = time() - $time;
        if (($val = floor($seconds / 31536000)) > 0) return $val . ' năm trước';
        if (($val = floor($seconds / 2592000)) > 0) return $val . ' tháng trước';
        if (($val = floor($seconds / 86400)) > 0) return $val . ' ngày trước';
        if (($val = floor($seconds / 3600)) > 0) return $val . ' giờ trước';
        if (($val = floor($seconds / 60)) > 0) return $val . ' phút trước';
        return $seconds . ' giây trước';
	}
}

if( ! function_exists('sec2hms'))
{	
	function sec2hms($sec, $padHours = false) {
	 
	    $hms = "";
	 
	    // there are 3600 seconds in an hour, so if we
	    // divide total seconds by 3600 and throw away
	    // the remainder, we've got the number of hours
	    $hours = intval(intval($sec) / 3600); 
	 
	    // add to $hms, with a leading 0 if asked for
	    $hms .= ($padHours) 
	          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
	          : $hours. ':';
	 
	    // dividing the total seconds by 60 will give us
	    // the number of minutes, but we're interested in 
	    // minutes past the hour: to get that, we need to 
	    // divide by 60 again and keep the remainder
	    $minutes = intval(($sec / 60) % 60); 
	 
	    // then add to $hms (with a leading 0 if needed)
	    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
	 
	    // seconds are simple - just divide the total
	    // seconds by 60 and keep the remainder
	    $seconds = intval($sec % 60); 
	 
	    // add to $hms, again with a leading 0 if needed
	    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	 
	    return $hms;
	}
}

if( ! function_exists('jdate_format'))
{
	function jdate_format($dateString)
	{
	    $pattern = array(       
	        //day
	        'd',        //day of the month
	        'j',        //3 letter name of the day
	        'l',        //full name of the day
	        'z',        //day of the year
	         
	        //month
	        'F',        //Month name full
	        'M',        //Month name short
	        'n',        //numeric month no leading zeros
	        'm',        //numeric month leading zeros
	         
	        //year
	        'Y',        //full numeric year
	        'y'     //numeric year: 2 digit
	    );

	    $replace = array(
	        'dd','d','DD','o',
	        'MM','M','m','mm',
	        'yy','y'
	    );

	    foreach($pattern as & $p)
	    {
	        $p = '/'.$p.'/';
	    }

	    return preg_replace($pattern, $replace, $dateString);
	}	
}
