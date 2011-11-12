<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if ( ! function_exists('asset_url')) 
{	
    function asset_url($uri = '') 
    {	
        $CI = & get_instance();

        $asset_url = $CI->config->slash_item('asset_url');

        if ($uri == '') return $asset_url;					
            
        return $asset_url . trim($uri, '/');
    }
}

if ( ! function_exists('asset_link_tag')) 
{		
    function asset_link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '') 
    {						
        $CI =& get_instance();
        $link = '<link ';
        if (is_array($href))
        {
            foreach ($href as $k => $v)
            {
                if ($k == 'href' AND strpos($v, '://') === FALSE)
                {					
                    $link .= 'href="'.asset_url($v).'" ';					
                }
                else
                {
                    $link .= "$k=\"$v\" ";
                }
            }

            $link .= "/>";
        }
        else
        {
            if ( strpos($href, '://') !== FALSE)
            {
                $link .= 'href="'.$href.'" ';
            }			
            else
            {
                $link .= 'href="'.asset_url($href).'" ';
            }

            $link .= 'rel="'.$rel.'" type="'.$type.'" ';

            if ($media	!= '')
            {
                $link .= 'media="'.$media.'" ';
            }

            if ($title	!= '')
            {
                $link .= 'title="'.$title.'" ';
            }

            $link .= '/>';
        }
        
        return $link;																								
    }
}

if ( ! function_exists('asset_js')) 
{		
    function asset_js($src = '', $type = 'text/javascript') 
    {						
        $CI =& get_instance();

        $link = '<script ';
        
        if (is_array($src))
        {
            foreach ($src as $k => $v)
            {
                if ($k == 'src' AND strpos($v, '://') === FALSE)
                {					
                    $link .= 'src="'.asset_url($v).'" ';					
                }
                else
                {
                    $link .= "$k=\"$v\" ";
                }
            }

            $link .= "></script>";
        }
        else
        {
            if ( strpos($src, '://') !== FALSE)
            {
                $link .= 'src="'.$src.'" ';
            }			
            else
            {
                $link .= 'src="'.asset_url($src).'" ';
            }

            $link .= 'type="'.$type.'" ';

            
            $link .= '></script>';
        }
        
        return $link;																								
    }
}