<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller
{
  
  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('url', 'general', 'date'));
    date_default_timezone_set('Asia/Jakarta');

    $username    = $this->security->xss_clean($this->input->post('username'));
    $password    = $this->security->xss_clean($this->input->post('password'));
    if(
      !empty($username) &&
      !empty($password)
      )
    {
      $this->customer_id = $this->_check($username, $password);
    }else
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'Error page'
          )
        );
      die();
    }
  }

  public function general_request()
  {
    $damage          = $this->security->xss_clean($this->input->post('damage'));    
    $detail_location = $this->security->xss_clean($this->input->post('detail_location'));
    $latlng          = $this->security->xss_clean($this->input->post('latlng'));
    $customer_id     = $this->customer_id;

    if(
      $customer_id             &&
      !empty($damage)          &&
      !empty($detail_location) &&
      !empty($latlng)
      )
    {
      // location
      $location_now = fix_location($latlng);

      $query = $this->db->select('id, latlng');
      $query = $this->db->from('beo_bengkel');
      $query = $this->db->get();

      $distance = array();
      $d        = array();
      foreach ($query->result() as $row)
      {
        $latlng             = json_decode($row->latlng);
        $dis                = distance($location_now['lat'], $location_now['lng'], $latlng->lat, $latlng->lng);
        $distance[$row->id] = $dis;
        $d[]                = $dis;
      }
      $near_id = array_search(min($d), $distance);

      // main data
      $data = array(
        'bengkel_id'      => $near_id,
        'customer_id'     => $customer_id,
        'latlng'          => json_encode($latlng),
        'detail_location' => $detail_location,
        'type'            => 1,
        'damage'          => $damage,
        'created'         => date('Y-m-d H:i:s')
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

  public function spesific_request()
  {
    $id_marker       = $this->security->xss_clean($this->input->post('id_marker'));
    $damage          = $this->security->xss_clean($this->input->post('damage'));    
    $detail_location = $this->security->xss_clean($this->input->post('detail_location'));
    $latlng          = $this->security->xss_clean($this->input->post('latlng'));
    $customer_id     = $this->customer_id;
    
    if(
      $customer_id             &&
      !empty($id_marker)       &&
      !empty($damage)          &&
      !empty($detail_location) &&
      !empty($latlng)
      )
    {
      // get bengkel_id
      $query      = $this->db->select('id');
      $query      = $this->db->from('beo_bengkel');
      $query      = $this->db->where('id_marker', $id_marker);
      $query      = $this->db->get();
      $bengkel_id = $query->row()->id;
      // location
      $latlng = fix_location($latlng);
      // main data
      $data = array(
        'bengkel_id'      => $bengkel_id,
        'customer_id'     => $customer_id,
        'latlng'          => json_encode($latlng),
        'detail_location' => $detail_location,
        'type'            => 2,
        'damage'          => $damage,
        'created'         => date('Y-m-d H:i:s')
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

  public function _check($username, $password)
  {
    if(
      !empty($username)&&
      !empty($password)
      )
    {
      $ph = password_hash($password, PASSWORD_BCRYPT);

      $query  = $this->db->select('id, pass');
      $query  = $this->db->from('beo_customer');
      $query  = $this->db->where('username', $username);
      $query  = $this->db->get();
      if($query->num_rows() > 0)
      {
        $result = $query->row()->pass;
        if(password_verify($result, $ph))
        {
          return $query->row()->id;
        }else {
          return 0;
        }
      }else{
        return 0;
      }   
    }
  }
}