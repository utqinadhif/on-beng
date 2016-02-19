<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_bengkel extends CI_Controller
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
    redirect(base_url('data_bengkel/view'));
  }

  function view()
  {
    $config['per_page']         = 10;
    $config['num_links']        = 5;
    $config['use_page_numbers'] = TRUE;
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
    $config['base_url']         = base_url('data_bengkel/view');
    $config['uri_segment']      = 3;

    $search = $this->security->xss_clean($this->input->post('search'));
    $submit = $this->security->xss_clean($this->input->post('submit'));
    $reset  = $this->security->xss_clean($this->input->post('reset'));

    if(!empty($search) && !empty($submit))
    {
      $this->session->set_userdata('search_bengkel', $search);
      redirect(base_url('data_bengkel/view'));
    }else
    if(!empty($reset) || (!empty($submit) && empty($search)))
    {
      $this->session->unset_userdata('search_bengkel');
      redirect(base_url('data_bengkel/view'));
    }

    if($key = $this->session->userdata('search_bengkel'))
    {
      $config['total_rows'] = $this->db->like('id_marker', $key)
                                      ->or_where("profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->get('beo_bengkel')
                                      ->num_rows();
      $data['data']         = $this->db->like('id_marker', $key)
                                      ->or_where("profile REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->or_where("latlng REGEXP '\"([^\"]*)([^\"]*)\":\"([^\"]*)$key([^\"]*)\"'")
                                      ->limit($config['per_page'], $offset)
                                      ->order_by("created","desc")
                                      ->get('beo_bengkel');
      $data['key']          = $key != '*' ? $key : '';
    }else{
      $config['total_rows'] = $this->db->get("beo_bengkel")->num_rows();
      $data['data']         = $this->db->limit($config['per_page'], $offset)->order_by("created","desc")->get("beo_bengkel");
    }
 
    $this->pagination->initialize($config);    
    $data['paging']    = $this->pagination->create_links();
    $data['num_start'] = $offset + 1;
    $data['total']     = $config['total_rows'];

    $this->load->view('data/bengkel/view', $data);
  }
}