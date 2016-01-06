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
    $all = $this->db->order_by('id_marker', 'asc');
    $all = $this->db->get('beo_bengkel');
    $all = $all->result();

    foreach ($all as $k => $v) {
      $profile  = json_decode($v->profile);
      $latlng = json_decode($v->latlng);

      $v->name = $profile->name;
      $key = $v->id_marker;
      $result[] = array(
        "id"        => $v->id,
        "id_marker" => $v->id_marker,
        "name"      => $profile->name,
        "company"   => $profile->company,
        "contact"   => $profile->contact,
        "email"     => $profile->email,
        "location"  => $profile->location,
        "lat"       => $latlng->lat,
        "lng"       => $latlng->lng,
        "created"   => $v->created,
        "updated"   => $v->updated,
        );
    }

    $output["ok"] = 1;
    $output["result"] = $result;

    pretty_json($output);
  }
}