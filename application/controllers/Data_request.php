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
    $this->load->view('data/nav');
  }
  public function index()
  {
    redirect(base_url('data_request/view'));
  }

  function view($offset=0)
  {    
    $config['base_url']         = base_url('data_request/view');
    $config['total_rows']       = $this->db->get("beo_request")->num_rows();
    $config['per_page']         = 10;
    $config['uri_segment']      = 3;
    $config['num_links']        = 5;
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
    
    $this->pagination->initialize($config);    
    $data['paging']    = $this->pagination->create_links();
    $data['data']      = $this->db->limit($config['per_page'], $offset)->get("beo_request");
    $data['num_start'] = $offset + 1;
    $data['total']     = $config['total_rows'];

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