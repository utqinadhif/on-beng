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

  public function request()
  {
    $id_marker       = $this->security->xss_clean($this->input->post('id_marker'));
    $damage          = $this->security->xss_clean($this->input->post('damage'));    
    $detail_location = $this->security->xss_clean($this->input->post('detail_location'));
    $latlng          = $this->security->xss_clean($this->input->post('latlng'));
    $type            = $this->security->xss_clean($this->input->post('type'));
    $customer_id     = $this->customer_id;
    
    if(
      $customer_id             &&
      !empty($id_marker)       &&
      !empty($damage)          &&
      !empty($detail_location) &&
      !empty($latlng)
      )
    {
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
        'type'            => $type,
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

  public function search_price()
  {
    $latlng    = $this->security->xss_clean($this->input->post('latlng'));
    $id_marker = $this->security->xss_clean($this->input->post('id_marker'));

    if(!$id_marker)
    {
      $id_marker = $this->_search_near($latlng);
    }

    $query = $this->db->select('latlng, profile')
                      ->from('beo_bengkel')
                      ->where('id_marker', $id_marker)
                      ->get();

    $ori = fix_location($latlng);
    $des = json_decode($query->row()->latlng);
    
    $a        = distance($ori['lat'], $ori['lng'], $des->lat, $des->lng);
    $b        = g_distance($ori['lat'], $ori['lng'], $des->lat, $des->lng);
    $distance = max($a, $b);

    $c     = json_decode($query->row()->profile);
    $price = $c->price;

    $result[] = array(
      'id_marker' => floatval($id_marker),
      'price'     => floatval($price),
      'distance'  => floatval($distance),
      'amount'    => $price*$distance
      );

    $output['ok']     = 1;
    $output['result'] = $result;
    pretty_json($output);
  }

  public function get_data()
  {
    $page     = intval($this->uri->segment(3));
    $per_page = 1;
    $offset   = $page == 0 ? $page : $page * $per_page - $per_page;
    $data     = $this->db->select('r.id, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, r.created, r.type, r.detail_location, r.latlng AS latlng_order, r.damage, r.status')
                    ->from('beo_request AS r')
                    ->join('beo_customer AS c', 'r.customer_id = c.id', 'left')
                    ->join('beo_bengkel AS b', 'r.bengkel_id = b.id', 'left')
                    ->where('r.customer_id', $this->customer_id)
                    ->limit($per_page, $offset)->get();
    $status = array('','waiting', 'confirm', 'cancel', 'fail', 'done');
    $result = array();
    foreach ($data->result() as $v) {
      $profile_bengkel = json_decode($v->profile_bengkel);
      $latlng_bengkel  = json_decode($v->latlng_bengkel);
      $latlng_order    = json_decode($v->latlng_order);

      $result[] = array(
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        'id'=> $v->id,
        );
    }

    $output['ok']     = 1;
    $output['result'] = $result;
    pretty_json($output);
  }

  public function _check($username, $password)
  {
    if(
      !empty($username)&&
      !empty($password)
      )
    {
      $ph = password_hash($password, PASSWORD_BCRYPT);

      $query  = $this->db->select('id, pass')
                          ->from('beo_customer')
                          ->where('username', $username)
                          ->get();
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

  public function _search_near($latlng)
  {
    $location_now = fix_location($latlng);

    $query = $this->db->select('id_marker, latlng')
                      ->from('beo_bengkel')
                      ->get();

    $distance = array();
    $d        = array();
    foreach ($query->result() as $row)
    {
      $latlng                    = json_decode($row->latlng);
      $dis                       = distance($location_now['lat'], $location_now['lng'], $latlng->lat, $latlng->lng);
      $distance[$row->id_marker] = $dis;
      $d[]                       = $dis;
    }
    return $near_id__marker = array_search(min($d), $distance);
  }
}