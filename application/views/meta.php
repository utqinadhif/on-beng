<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper(array('html'));
echo doctype('html5');
$meta = array(
  array('name' => 'robots', 'content' => 'no-cache'),
  array('name' => 'description', 'content' => 'On-Beng Online Bengkel'),
  array('name' => 'keywords', 'content' => 'bengkel, online, bengkel online, onbeng, pati'),
  array('name' => 'robots', 'content' => 'no-cache'),
  array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
  array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1')
  );

echo meta($meta);
echo link_tag(base_url('assets/custom.css'));
$link = array(
  'href' => base_url('assets/images/bengkel-icon.png'),
  'rel' => 'shortcut icon'
  );
echo link_tag($link);
?>