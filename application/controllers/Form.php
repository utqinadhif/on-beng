<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller
{
  
  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('url', 'general', 'date'));
    date_default_timezone_set('Asia/Jakarta');
  }
  public function general_register()
  {
    //search near bengkel from current location
    $name           = $this->security->xss_clean($this->input->post('name'));
    $email          = $this->security->xss_clean($this->input->post('email'));
    $contact        = $this->security->xss_clean($this->input->post('contact'));
    $detail_address = $this->security->xss_clean($this->input->post('detail_adress'));
    $location       = $this->security->xss_clean($this->input->post('location'));

    if(!empty($name) &&
      !empty($email) &&
      !empty($contact) &&
      !empty($location))
    {
      // location
      $location_now = fix_location($location);

      $query = $this->db->select('id, location');
      $query = $this->db->from('beo_bengkel');
      $query = $this->db->get();

      $distance = array();
      $d        = array();
      foreach ($query->result() as $row)
      {
        $location           = json_decode($row->location);
        $dis                = distance($location_now['lat'], $location_now['lng'], $location->lat, $location->lng);
        $distance[$row->id] = $dis;
        $d[]                = $dis;
      }
      $near_id = array_search(min($d), $distance);
      //profile
      $profile = array(
        'name'           => $name,
        'email'          => $email,
        'contact'        => $contact,
        'detail_address' => $detail_address
        );
      // main data
      $data = array(
        'bengkel_id' => $near_id,
        'profile'    => json_encode($profile),
        'location'   => json_encode($location_now),
        'type'       => 1
        );
      $save = $this->db->insert('beo_request', $data);
      if($save)
      {
        echo json_encode(
          array(
            'ok'  => 1,
            'msg' => 'Success'
            )
          );
      }else
      {
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'Error page'
            )
          );
      }
    }else
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'Error page'
          )
        );
    }
  }

  public function spesific_register()
  {
    $bengkel_id     = $this->security->xss_clean($this->input->post('bengkel_id'));
    $name           = $this->security->xss_clean($this->input->post('name'));
    $email          = $this->security->xss_clean($this->input->post('email'));
    $contact        = $this->security->xss_clean($this->input->post('contact'));
    $detail_address = $this->security->xss_clean($this->input->post('detail_adress'));
    $location       = $this->security->xss_clean($this->input->post('location'));

    if(!empty($bengkel_id) &&
      !empty($name) &&
      !empty($email) &&
      !empty($contact) &&
      !empty($location))
    {
      // location
      $location = fix_location($location);
      //profile
      $profile = array(
        'name'           => $name,
        'email'          => $email,
        'contact'        => $contact,
        'detail_address' => $detail_address
        );
      // main data
      $data = array(
        'bengkel_id' => $bengkel_id,
        'profile'    => json_encode($profile),
        'location'   => json_encode($location),
        'type'       => 2
        );
      $save = $this->db->insert('beo_request', $data);
      if($save)
      {
        echo json_encode(
          array(
            'ok'  => 1,
            'msg' => 'Success'
            )
          );
      }else
      {
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'Error page'
            )
          );
      }
    }else
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'Error page'
          )
        );
    }
  }
}