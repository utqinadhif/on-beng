<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('pretty_json'))
{
  function pretty_json($array)
  {
    $output = '{}';
    if (!empty($array))
    {
      if (!is_array($array))
      {
        $output = $array;
      }else
      {
        if (defined('JSON_PRETTY_PRINT'))
        {
          $output = json_encode($array, JSON_PRETTY_PRINT);
        }else{
          $output = json_encode($array);
        }
      }
    }
    header('content-type: application/json; charset: UTF-8');
    echo $output;
    exit();
  }
}

if(!function_exists('fix_location'))
{
  function fix_location($location)
  {
    $lok      = explode(', ', $location);
    $lat      = str_replace('(', '', $lok[0]);
    $lng      = str_replace(')', '', $lok[1]);
    $location = array(
      'lat'=> $lat,
      'lng'=> $lng
      );
    return $location;
  }
}

if(!function_exists('is_json'))
{
  function is_json($string)
  {
    return ((is_string($string) &&
      (is_object(json_decode($string)) ||
        is_array(json_decode($string)))))
    ? true
    : false;
  }
}
