<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jajal extends CI_Controller
{
 
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('SSP', 'table'));
    $this->load->helper(array('url', 'general', 'date'));
  }

  function index()
  {
    $tmpl = array('table_open' => '<table id="big_table" class="table table-striped" cellspacing="0" width="100%">');
    $this->table->set_template($tmpl);

    $this->table->set_heading('#','Bengkel Name','Company','Contact','Email','Location','Created','Updated');
    $this->load->view('meta');
    $this->load->view('script');
    $this->load->view('jajal');
  }

  function datatable()
  {
    $table      = 'beo_bengkel';
    $primaryKey = 'id';
 
    $columns = array(
        array( 'db' => 'id', 'dt' => 0 ),
        array( 'db' => 'id', 'dt' => 1 ),
        array( 'db' => 'profile', 'dt' => 2 ),
        array( 'db' => 'latlng', 'dt' => 3 ),
        array( 'db' => 'created', 'dt' => 4 ),
        array( 'db' => 'updated', 'dt' => 5 ),
    );

    $sql_details = array(
        'user' => 'root',
        'pass' => '',
        'db'   => 'onbeng',
        'host' => 'localhost'
    );

    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    );
  }
}