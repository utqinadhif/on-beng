<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_request extends CI_Controller
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
    $this->load->view('meta');
    $this->load->view('script');
  }
  public function index()
  {
    redirect(base_url('data_request/view'));
  }

  function view()
  {
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
    $config['base_url']         = base_url('data_request/view');
    $config['uri_segment']      = 3;

    $search                     = $this->security->xss_clean($this->input->post('search'));
    if(!empty($search))
    {
      $this->session->set_userdata('search_request', $search);
      if($search == '*') $this->session->unset_userdata('search_request');
    }

    if($key = $this->session->userdata('search_request'))
    {
      $config['total_rows'] = $this->db->select('r.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, r.created, r.type, r.detail_location, r.latlng AS latlng_order, r.damage, r.status')
                                      ->from('beo_request AS r')
                                      ->join('beo_customer AS c', 'r.customer_id = c.id', 'left')
                                      ->join('beo_bengkel AS b', 'r.bengkel_id = b.id', 'inner')
                                      ->like('r.id', $key)
                                      ->or_like('r.detail_location', $key)
                                      ->or_like('c.username', $key)
                                      ->or_where("c.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("c.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("r.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                                      ->or_where("b.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->get()
                                      ->num_rows();
      
      $data['data'] = $this->db->select('r.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, r.created, r.type, r.detail_location, r.latlng AS latlng_order, r.damage, r.status')
                              ->from('beo_request AS r')
                              ->join('beo_customer AS c', 'r.customer_id = c.id', 'left')
                              ->join('beo_bengkel AS b', 'r.bengkel_id = b.id', 'inner')
                              ->like('r.id', $key)
                              ->or_like('r.detail_location', $key)
                              ->or_like('c.username', $key)
                              ->or_where("c.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                              ->or_where("c.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                              ->or_where("r.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                              ->or_where("b.latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")     
                              ->or_where("b.profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                              ->order_by('r.created', 'desc')
                              ->limit($config['per_page'], $offset)
                              ->get();

      $data['key']          = $key != '*' ? $key : '';
    }else{
      $config['total_rows'] = $this->db->get("beo_request")->num_rows();
      $data['data']         = $this->db->select('r.id, c.username, c.profile AS profile_customer, c.latlng AS latlng_customer, b.profile AS profile_bengkel, b.latlng AS latlng_bengkel, r.created, r.type, r.detail_location, r.latlng AS latlng_order, r.damage, r.status')
                                        ->from('beo_request AS r')
                                        ->join('beo_customer AS c', 'r.customer_id = c.id', 'left')
                                        ->join('beo_bengkel AS b', 'r.bengkel_id = b.id', 'left')
                                        ->order_by('r.created', 'desc')
                                        ->limit($config['per_page'], $offset)->get();
    }
    
    $this->pagination->initialize($config);    
    $data['paging']      = $this->pagination->create_links();
    $data['num_start']   = $offset + 1;
    $data['total']       = $config['total_rows'];
    $data['status_text'] = array('Waiting', 'Confirm', 'Fail');

    $this->load->view('data/request/view', $data);
  }

  function approve($id)  //approve to consumen that service on going
  {
  }

  function cancel($id) //approve to consumen that service can not began
  {
  }

  function edit($id) //edit request from consumen
  {
  }
}