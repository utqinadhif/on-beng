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

if(!function_exists('distance'))
{
  function distance($lat1, $lng1, $lat2, $lng2)
  {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;
   
    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
   
    return $km;
  }
}

if(!function_exists('g_distance'))
{
  function g_distance($lat1, $lng1, $lat2, $lng2)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat1,$lng1&destinations=$lat2,$lng2&mode=driving&language=en-EN&sensor=false");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($ch);
    curl_close ($ch);

    $a = json_decode($server_output);
    return preg_replace('~ km$~', '', $a->rows[0]->elements[0]->distance->text);
  }
}

if(!function_exists('alert'))
{
  function alert($msg)
  {
    $m = '<div class="alert alert-danger">';
    $m .= '<i class="fa fa-exclamation-triangle"></i>';
    $m .= $msg;
    $m .= '</div>';  
    return $m;
  }
}