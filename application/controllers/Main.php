<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('session'));
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$this->load->view('meta');
		$this->load->view('script');
		$this->load->view('query_data');
		$this->load->view('main/view');
	}


	public function login()
	{
		$user = $this->security->xss_clean($this->input->post('user'));
		$pass = $this->security->xss_clean($this->input->post('pass'));
		$ph   = password_hash($pass, PASSWORD_BCRYPT);

		if(!empty($user) && !empty($pass))
		{
			$query  = $this->db->select('pass');
      $query  = $this->db->from('beo_admin');
      $query  = $this->db->where('user', $user);
      $query  = $this->db->get();
      $result = $query->row()->pass;
      if(password_verify($result, $ph)){
      	$sess = array(
      		'user' => $user,
      		'ip'   => $this->input->ip_address()
      		);

      	$this->session->set_userdata('logged', $sess);

      	$data = array(
      		'last_login' => date('Y-m-d H:i:s')
      		);
      	$update = $this->db->where('user', $user);
      	$update = $this->db->update('beo_admin', $data);
      	echo json_encode(
      		array(
		        'ok'  => 1,
		        'msg' => 'success',
		        'href'=> base_url('marker')
	        	)
					);
      }else
      {
      	echo json_encode(
					array(
		        'ok'  => 0,
		        'msg' => 'Error login'
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

	public function load($id)
	{
		switch ($id) {
			case '1':
				$this->load->view('main/how-to-use');
				break;
			case '2':
				$this->load->view('main/about');
				break;			
			default:
				echo json_encode(array(
	        'ok'  => 0,
	        'msg' => 'Error page'
        	)
				);
				break;
		}
	}
	
}