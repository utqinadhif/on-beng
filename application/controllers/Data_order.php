<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_order extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('url', 'general', 'date'));
    $this->load->library(array('session', 'pagination'));
    date_default_timezone_set('Asia/Jakarta');
    if(!$this->session->userdata('logged'))
    {
      redirect('main');
    }
  }
  public function index()
  {
    redirect(base_url('data_order/view'));
  }

  function view()
  {
    $this->load->view('meta');
    $this->load->view('script');

    $config['per_page']         = 10;
    $config['num_links']        = 5;
    $config['use_page_numbers']  = TRUE;
    $config['full_tag_open']    = "<ul class='pagination pagination-sm' style='position:relative; top:-25px;'>";
    $config['full_tag_close']   = "</ul>";
    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['cur_tag_open']     = "<li class='active disabled'><a>";
    $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
    $config['next_tag_open']    = "<li>";
    $config['next_tagl_close']  = "</li>";
    $config['prev_tag_open']    = "<li>";
    $config['prev_tagl_close']  = "</li>";
    $config['first_tag_open']   = "<li>";
    $config['first_tagl_close'] = "</li>";
    $config['last_tag_open']    = "<li>";
    $config['last_tagl_close']  = "</li>";
    $page                       = intval($this->uri->segment(3));
    $offset                     = $page == 0 ? $page : $page * $config['per_page'] - $config['per_page'];
    $config['base_url']         = base_url('data_order/view');
    $config['uri_segment']      = 3;

    $search = $this->security->xss_clean($this->input->post('search'));
    $submit = $this->security->xss_clean($this->input->post('submit'));
    $reset  = $this->security->xss_clean($this->input->post('reset'));

    if(!empty($search) && !empty($submit))
    {
      $this->session->set_userdata('search_order', $search);
      redirect(base_url('data_order/view'));
    }else
    if(!empty($reset) || (!empty($submit) && empty($search)))
    {
      $this->session->unset_userdata('search_order');
      redirect(base_url('data_order/view'));
    }

    if(!empty($key = $this->session->userdata('search_order')))
    {
      $config['total_rows'] = $this->db->select('o.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, o.latlng AS latlng_order, o.detail_order, o.type, o.created, o.status')
                                      ->from('beo_order AS o')
                                      ->join('beo_customer AS c', 'o.customer_id = c.id', 'left')
                                      ->join('beo_bengkel AS b', 'o.bengkel_id = b.id', 'inner')
                                      ->like('o.id', $key)
                                      ->or_like('c.username', $key)
                                      ->or_where("o.detail_order REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("c.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("c.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("o.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->get()
                                      ->num_rows();
      
      $data['data'] = $this->db->select('o.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, o.latlng AS latlng_order, o.detail_order, o.type, o.created, o.status')
                                      ->from('beo_order AS o')
                                      ->join('beo_customer AS c', 'o.customer_id = c.id', 'left')
                                      ->join('beo_bengkel AS b', 'o.bengkel_id = b.id', 'inner')
                                      ->like('o.id', $key)
                                      ->or_like('c.username', $key)
                                      ->or_where("o.detail_order REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("c.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("c.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("o.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->get();

      $data['key']          = $key != '*' ? $key : '';
    }else{
      $config['total_rows'] = $this->db->get("beo_order")->num_rows();
      $data['data']         = $this->db->select('o.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, o.latlng AS latlng_order, o.detail_order, o.type, o.created, o.status')
                                        ->from('beo_order AS o')
                                        ->join('beo_customer AS c', 'o.customer_id = c.id', 'left')
                                        ->join('beo_bengkel AS b', 'o.bengkel_id = b.id', 'left')
                                        ->order_by('o.created', 'desc')
                                        ->limit($config['per_page'], $offset)->get();
    }

    $status   = array('waiting', 'process', 'confirm', 'cancel', 'done');
    $status_v = array(
      array(1, 3),
      array(3),
      array(4),
      array(),
      array()
      );
    
    $this->pagination->initialize($config);    
    $data['paging']      = $this->pagination->create_links();
    $data['num_start']   = $offset + 1;
    $data['total']       = $config['total_rows'];
    $data['status_text'] = array(
      'status'   => $status,
      'status_v' => $status_v
      );

    $this->load->view('data/order/view', $data);
  }

  function change_status($id)  //approve to consumen that service on going
  {
    $value = $this->security->xss_clean($this->input->post('value'));
    if(!empty($id) && !empty($value))
    {
      $data = array(
        'status'  => $value
        );
      $update = $this->db->where('id', $id);
      $update = $this->db->update('beo_order', $data);

      $status   = array('waiting', 'process', 'confirm', 'cancel', 'done');
      $status_v = array(
        array(1, 3),
        array(3),
        array(4),
        array(),
        array()
        );

      if($update)
      {
        $option = '<option>Choose</option><option disabled="true">_________</option>';
        foreach ($status_v[$value] as $vs)
        {
          $option .= '<option value="'.$vs.'">'.ucfirst($status[$vs]).'</option>';                  
        }
        echo json_encode(
        array(
          'ok'          => 1,
          'msg'         => 'success',
          'option'      => $option,
          'status'      => $value,
          'status_text' => ucfirst($status[$value])
          )
        );
      }else{
        echo json_encode(
          array(
            'ok'  => 0,
            'msg' => 'Update fail'
            )
          );
      }
    }else{
      echo json_encode(
        array(
          'ok'  => 0,
          'msg' => 'One data is empty'
          )
        );
    }
  }
}