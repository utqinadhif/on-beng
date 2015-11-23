<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
	}

	public function index()
	{
		$this->load->view('meta');
		$this->load->view('home/nav');
		$this->load->view('script');
		$this->load->view('home/content');
	}

	public function first()
	{
		$this->load->view('home/first');
	}

	public function login()
	{
		$post = $this->security->xss_clean($this->input->post());
		if(!empty($post))
		{
			echo json_encode(array(
				'ok'  => 1,
				'href' => base_url('admin')
				)
			);
		}else
		{
			$this->load->view('home/login');
		}
	}

	public function info()
	{
		$this->load->view('home/info');
	}

	public function about()
	{
		$this->load->view('home/about');
	}
	
}