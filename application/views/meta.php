<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper(array('html', 'header'));
echo doctype('html5');
$meta = array(
  array('name' => 'robots', 'content' => 'no-cache'),
  array('name' => 'description', 'content' => get_title()),
  array('name' => 'keywords', 'content' => 'bengkel, online, bengkel online, onbeng, pati'),
  array('name' => 'robots', 'content' => 'no-cache'),
  array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
  array('name' => 'expires', 'content' => '0', 'type' => 'equiv'),
  array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1'),
  array('name' => 'revisit-after', 'content' => '2 Days'),
  array('name' => 'language', 'content' => 'en-us')
  );

echo meta($meta);
echo link_tag(base_url('assets/custom.css'));
$link = array(
  'href' => base_url('assets/images/bengkel-icon.png'),
  'rel' => 'shortcut icon'
  );
echo link_tag($link);
echo get_title(TRUE);
?>