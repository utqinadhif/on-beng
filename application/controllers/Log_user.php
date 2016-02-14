<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_user extends CI_Controller
{
  
  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('url', 'general', 'date'));
    date_default_timezone_set('Asia/Jakarta');
  }

  public function login()
  {
    $username    = $this->security->xss_clean($this->input->post('username'));
    $password    = $this->security->xss_clean($this->input->post('password'));
    if(
      !empty($username) &&
      !empty($password)
      )
    {
      $ph = password_hash($password, PASSWORD_BCRYPT);

      $query = $this->db->select();
      $query = $this->db->from('beo_customer');
      $query = $this->db->where('username', $username);
      $query = $this->db->get();
      $all   = $query->result();
      $res   = $query->row();
      if(password_verify(@$res->pass, $ph))
      {
        foreach ($all as $k => $v) {
          $profile  = json_decode($v->profile);
          $result[] = array(
            'id'       => $v->id,
            'name'     => @$profile->name,
            'username' => $v->username,
            'pass'     => $v->pass,
            'contact'  => @$profile->contact,
            'location' => @$profile->location,
            );
        }
        $output["ok"] = 1;
        $output["result"] = $result;

        pretty_json($output);

      }else{
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'Login Eror'
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

  public function signup()
  {
    $name     = $this->security->xss_clean($this->input->post('name'));
    $username = $this->security->xss_clean($this->input->post('username'));
    $password = $this->security->xss_clean($this->input->post('password'));
    $contact  = $this->security->xss_clean($this->input->post('contact'));
    $location = $this->security->xss_clean($this->input->post('location'));
    $latlng   = $this->security->xss_clean($this->input->post('latlng'));

    if(
      !empty($name)     &&
      !empty($username) &&
      !empty($password) &&
      !empty($contact)  &&
      !empty($location) &&
      !empty($latlng)
      )
    {
      // location
      $latlng = fix_location($latlng);
      // profile
      $profile = array(
        'name'     => $name,
        'contact'  => $contact,
        'location' => $location
        );
      $data = array(
        'username' => $username,
        'pass'     => $password,
        'profile'  => json_encode($profile),
        'latlng'   => json_encode($latlng),
        'created'  => date('Y-m-d H:i:s')
        );

      $save      = $this->db->insert('beo_customer', $data);
      $insert_id = $this->db->insert_id();
      if($save)
      {
        $result[] = array(
          'id'       => $insert_id,
          'name'     => $name,
          'username' => $username,
          'pass'     => $password,
          'contact'  => $contact,
          'location' => $location
          );

        $output["ok"]     = 1;
        $output["result"] = $result;
        pretty_json($output);
      }else{
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'No auth found'
            )
          );
      }
    }else
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'No auth found'
          )
        );
    }
  }

  public function update()
  {
    $id       = $this->security->xss_clean($this->input->post('id'));
    $name     = $this->security->xss_clean($this->input->post('name'));
    $username = $this->security->xss_clean($this->input->post('username'));
    $password = $this->security->xss_clean($this->input->post('password'));
    $contact  = $this->security->xss_clean($this->input->post('contact'));
    $location = $this->security->xss_clean($this->input->post('location'));
    $latlng   = $this->security->xss_clean($this->input->post('latlng'));

    if(
      !empty($id)       &&
      !empty($name)     &&
      !empty($username) &&
      !empty($password) &&
      !empty($contact)  &&
      !empty($location) &&
      !empty($latlng)
      )
    {
      // location
      $latlng = fix_location($latlng);
      // profile
      $profile = array(
        'name'     => $name,
        'contact'  => $contact,
        'location' => $location
        );
      $data = array(
        'username' => $username,
        'pass'     => $password,
        'profile'  => json_encode($profile),
        'latlng'   => json_encode($latlng),
        'updated'  => date('Y-m-d H:i:s')
        );

      $update = $this->db->where('id', $id);
      $update = $this->db->update('beo_customer', $data);
      
      if($update)
      {
        $result[] = array(
          'id'       => $id,
          'name'     => $name,
          'username' => $username,
          'pass'     => $password,
          'contact'  => $contact,
          'location' => $location
          );
        $output["ok"]     = 1;
        $output["result"] = $result;
        pretty_json($output);
      }else{
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'No auth found'
            )
          );
      }
    }else
    {
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'No auth found'
          )
        );
    }
  }
}