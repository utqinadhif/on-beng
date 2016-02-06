<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_title'))
{
  function set_title($title = 'Onbeng')
  {
    $CI =& get_instance();
    $CI->header_title = $title;
  }
}

if(!function_exists('get_title'))
{
  function get_title($html_title = FALSE)
  {
    $CI =& get_instance();
    if(!empty($CI->header_title))
    {
      $title = $CI->header_title;
    }else{
      $title = 'Onbeng';
    }

    if($html_title)
    {
      $title = "<title>{$title}</title>";
    }
    return $title;
  }
}