<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div role="navigation" class="navbar navbar-default">
  <div class="navbar-inner">
    <div class="container">
      <div class="navbar-header">
        <button type="button" data-target="#n" data-toggle="collapse" class="navbar-toggle">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="awal" class="navbar-brand" data-toggle="tooltip" title="Aplikasi Layanan Bengkel Online">On-Beng</a>
      </div>
      <div id="n" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Data yang Telah Diproses">Lihat Data Diproses</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php echo base_url('data_request/view');?>" data-toggle="tooltip" data-placement="bottom" title="View data from request">Data from request</a></li>
          <li><a href="<?php echo base_url('data_bengkel/view');?>" data-toggle="tooltip" data-placement="bottom" title="View data bengkel">Data bengkel</a></li>
          <li><a href="<?php echo base_url('marker/logout');?>" data-toggle="tooltip" data-placement="bottom" title="Log out from system">Log out</a></li>
        </ul>  
      </div>
    </div>
  </div>
</div>