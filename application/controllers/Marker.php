<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marker extends CI_Controller
{
	public function __construct()
	{
    parent::__construct();
    $this->load->helper(array('url', 'general', 'date'));
    $this->load->library(array('session'));
    date_default_timezone_set('Asia/Jakarta');
    if(!$this->session->userdata('logged'))
    {
      redirect('main');
    }
	}

	public function index()
	{
		$this->load->view('meta');
    $this->load->view('script');
    $this->load->view('query_data');
    $this->load->view('marker/view');
	}

	public function saveMarker()
	{
		$id_marker = $this->security->xss_clean($this->input->post('id_marker'));
		$name      = $this->security->xss_clean($this->input->post('name'));
		$company   = $this->security->xss_clean($this->input->post('company'));
		$contact   = $this->security->xss_clean($this->input->post('contact'));
		$email     = $this->security->xss_clean($this->input->post('email'));
		$location  = $this->security->xss_clean($this->input->post('location'));
    $latlng    = $this->security->xss_clean($this->input->post('latlng'));
    

    if(
      !empty($name)    &&
      !empty($company) &&
      !empty($contact) &&
      !empty($email)   &&
      !empty($location)
      )
    {
      // location
      $latlng = fix_location($latlng);
      //profile
      $profile = array(
        'name'     => $name,
        'company'  => $company,
        'contact'  => $contact,
        'email'    => $email,
        'location' => $location
        );
      // main data
  		$data = array(
  			'id_marker' => $id_marker,
  			'profile'   => json_encode($profile),
  			'latlng'    => json_encode($latlng),
        'created'   => date('Y-m-d H:i:s')
  			);

			$save = $this->db->insert('beo_bengkel', $data);
			if($save)
			{
				echo json_encode(
          array(
            'ok'  => 1,
            'msg' => 'Success'
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

	public function deleteMarker()
	{
		$id_marker = $this->security->xss_clean($this->input->post('id_marker'));

		if(!empty($id_marker))
		{
			$query = $this->db->where('id_marker', $id_marker);
			$query = $this->db->delete("beo_bengkel");
			
			echo json_encode(
        array(
  				'ok' => 1
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
	}

  public function updateMarker()
  {
    $id_marker = $this->security->xss_clean($this->input->post('id_marker'));
    $name      = $this->security->xss_clean($this->input->post('name'));
    $company   = $this->security->xss_clean($this->input->post('company'));
    $contact   = $this->security->xss_clean($this->input->post('contact'));
    $email     = $this->security->xss_clean($this->input->post('email'));
    $location  = $this->security->xss_clean($this->input->post('location'));
    $latlng    = $this->security->xss_clean($this->input->post('latlng'));


    if(
      !empty($name)    &&
      !empty($company) &&
      !empty($contact) &&
      !empty($email)   &&
      !empty($location)
      )
    {
      // location
      $latlng = fix_location($latlng);
      //profile
      $profile = array(
        'name'     => $name,
        'company'  => $company,
        'contact'  => $contact,
        'email'    => $email,
        'location' => $location
        );
      // main data
      $data = array(
        'id_marker' => $id_marker,
        'profile'   => json_encode($profile),
        'latlng'    => json_encode($latlng),
        'updated'   => date('Y-m-d H:i:s')
        );

      $update = $this->db->where('id_marker', $id_marker);
      $update = $this->db->update('beo_bengkel', $data);
      
      if($update)
      {
        echo json_encode(
          array(
            'ok'=>1
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

	public function searchMarker()
	{
		$id_marker = $this->security->xss_clean($this->input->post('id_marker'));

		if(!empty($id_marker))
		{
			$query = $this->db->where('id_marker', $id_marker);
			$query = $this->db->get("beo_bengkel");
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
          $profile = json_decode($row->profile);
          $latlng  = json_decode($row->latlng);

					echo json_encode(array(
						'ok'        => 1,
						'id_marker' => $row->id_marker,
						'name'      => $profile->name,
						'company'   => $profile->company,
						'contact'   => $profile->contact,
						'email'     => $profile->email,
            'location'  => $profile->location,
						'latlng'    => '('.$latlng->lat.', '.$latlng->lng.')'
						));
				}
			}else
			{
				echo json_encode(array(
					'ok' => 2
					));
			}
		}else
		{
			echo json_encode(array(
        'ok'  => 0,
        'msg' => 'Error page'
        ));
		}
	}

  public function checkUnchangedMarker()
  {
    $id_marker = $this->security->xss_clean($this->input->post('id_marker'));

    if(!empty($id_marker))
    {
      $query = $this->db->select('id_marker');
      $query = $this->db->from('beo_bengkel');
      $query = $this->db->where('id_marker', $id_marker);
      $query = $this->db->get();
      $count = $query->num_rows();
      if($count == 1)
      {
        echo json_encode(array(
        'ok'  => 1
        ));
      }else{
        echo json_encode(array(
        'ok'  => 2,
        'msg' => 'empty data'
        ));
      }
    }else
    {
      echo json_encode(array(
        'ok'  => 0,
        'msg' => 'Error page'
        ));
    }
  }

  public function logout()
  {
    $d    = $this->session->all_userdata();

    $data = array(
          'last_logout' => date('Y-m-d H:i:s')
          );
    $update = $this->db->where('user', $d['logged']['user']);
    $update = $this->db->update('beo_admin', $data);
    
    $sess = array(
      'user' => '',
      'ip'   => ''
      );
    $this->session->unset_userdata('logged', $sess);
    $this->session->unset_userdata('search');
    redirect('main');
  }
}