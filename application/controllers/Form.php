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

  public function order()
  {
    $customer_id     = $this->customer_id;
    $id_marker       = $this->security->xss_clean($this->input->post('id_marker'));
    $damage          = $this->security->xss_clean($this->input->post('damage'));    
    $detail_location = $this->security->xss_clean($this->input->post('detail_location'));
    $latlng          = $this->security->xss_clean($this->input->post('latlng'));
    $type            = $this->security->xss_clean($this->input->post('type'));
    $distance        = $this->security->xss_clean($this->input->post('distance'));
    $total_price     = $this->security->xss_clean($this->input->post('total_price'));
    
    if(
      !empty($customer_id)     &&
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
      // detail order
      $detail_order = array(
        'detail_location' => $detail_location,
        'damage'          => $damage,
        'distance'        => $distance,
        'total_price'     => $total_price
        );
      // main data
      $data = array(
        'bengkel_id'   => $bengkel_id,
        'customer_id'  => $customer_id,
        'latlng'       => json_encode($latlng),
        'detail_order' => json_encode($detail_order),
        'type'         => $type,
        'created'      => date('Y-m-d H:i:s')
        );
      $save = $this->db->insert('beo_order', $data);
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
    $per_page = 10;
    $offset   = $page == 0 ? $page : $page * $per_page - $per_page;
    $data     = $this->db->select('o.id, b.id_marker, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, o.created, o.type, o.latlng AS latlng_order, o.status, o.detail_order,')
                    ->from('beo_order AS o')
                    ->join('beo_customer AS c', 'o.customer_id = c.id', 'left')
                    ->join('beo_bengkel AS b', 'o.bengkel_id = b.id', 'left')
                    ->where('o.customer_id', $this->customer_id)
                    ->order_by('o.created', 'desc')
                    ->limit($per_page, $offset)->get();
    $total  = $this->db->where('customer_id', $this->customer_id)
                  ->get('beo_order')
                  ->num_rows();
    $status   = array('waiting', 'process', 'confirm', 'cancel', 'done');
    $result = array();
    foreach ($data->result() as $v) {
      $profile_bengkel = json_decode($v->profile_bengkel);
      $latlng_bengkel  = json_decode($v->latlng_bengkel);
      $latlng_order    = json_decode($v->latlng_order);
      $detail_order    = json_decode($v->detail_order);

      $result[] = array(
        'id'                => intval($v->id),
        'logo_bengkel'      => short_name($profile_bengkel->name),
        'name_bengkel'      => $profile_bengkel->name,
        'date_order'        => $v->created,
        'status_order'      => intval($v->status),
        'status_order_text' => $status[$v->status],
        'damage_order'      => $detail_order->damage,
        'detail_bengkel'    => array(
          'id_marker' => floatval($v->id_marker),
          'company'   => $profile_bengkel->company,
          'contact'   => $profile_bengkel->contact,
          'email'     => $profile_bengkel->email,
          'location'  => $profile_bengkel->location,
          'price'     => $profile_bengkel->price,
          'lat'       => $latlng_bengkel->lat,
          'lng'       => $latlng_bengkel->lng
          ),
        'detail_order' => array(
          'detail_location' => $detail_order->detail_location,
          'lat'             => $latlng_order->lat,
          'lng'             => $latlng_order->lng,
          'distance'        => $detail_order->distance,
          'total_price'     => $detail_order->total_price
          )
        );
    }

    $output['ok']         = 1;
    $output['result']     = array(
      'list'       => $result,
      'per_page'   => $per_page,
      'total_data' => $total,
      'total_page' => ceil($total/$per_page)
      );
    pretty_json($output);
  }

  public function change_status($status, $id_order)
  {
    $c_data = $this->db->select('id, status')
              ->from('beo_order')
              ->where('customer_id', $this->customer_id)
              ->get();
    if(!empty($c_data))
    {
      foreach ($c_data->result() as $dt)
      {
        $id_orders[] = $dt->id;
        $dt_sts[]    = $dt->status;
      }
      if(in_array($id_order, $id_orders))
      {
        $key      = array_search($id_order, $id_orders);
        $s        = array('waiting', 'process', 'confirm', 'cancel', 'done');
        $status_v = array(
          array(3),
          array(2, 3),
          array(),
          array(),
          array()
          );
        if(in_array($status, $status_v[$dt_sts[$key]]))
        {
          $data = array(
            'status' => $status
            );
          $update = $this->db->where('id', $id_order);
          $update = $this->db->update('beo_order', $data);
          if($update)
          {
            $output = array(
              'ok'     => 1,
              'result' => array(
                'status'      => $status,
                'status_text' => $s[$status],
                )
              ); 
          }else{
            $output = array(
              'ok'  => 0,
              'msg' => 'update fail'
              ); 
          }
        }else{
          $output = array(
            'ok'  => 0,
            'msg' => 'status can\'t change'
            );
        }        
      }else{
        $output = array(
          'ok'  => 0,
          'msg' => 'data not found'
          );
      }
    }else{
      $output = array(
        'ok'  => 0,
        'msg' => 'no data, may be your order list is empty'
        );
    }
    echo json_encode($output);
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