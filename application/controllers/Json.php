<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('general', 'path', 'url'));

    $beo = $this->security->xss_clean($this->input->post('beo'));
    if(empty($beo) && $beo!='038')
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'No auth found'
          )
        );
      exit();
    }
  }

  public function view($id_marker = null)
  {
    if($id_marker != null)
    {
      $all = $this->db->where('id_marker', $id_marker);
    }
    $all = $this->db->get('beo_bengkel');
    $all = $all->result();

    foreach ($all as $k => $v) {
      $v->profile  = json_decode($v->profile);
      $v->location = json_decode($v->location);
      $key = $v->id_marker;
      unset($v->id_marker);
      $result[$key] = $v;
    }

    pretty_json($result);
  }

  /*
  this function for insert, confirm and cancel from user side
  */
  public function insert()
  {
  }

  public function confirm()
  {
  }

  public function cancel()
  {
  }
}