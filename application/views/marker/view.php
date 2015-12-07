<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
	<div class="col-md-1 col-sm-2 col-xs-4 menu affix">
	  <button type="button" class="btn btn_menu">
	    <i class="fa fa-bars"></i> Menu
	  </button>
	  <div class="item">
	    <ul>
	      <a href="<?php echo base_url('data_request/view'); ?>" title="View data customer" data-toggle="tooltip"><li><i class="fa fa-database fa-6"></i></li></a>
	    </ul>
	    <ul>
	      <a href="" title="Information about this application" data-toggle="tooltip"><li><i class="fa fa-question fa-6"></i></li></a>
	    </ul>
	    <ul>
	      <a href="<?php echo base_url('marker/logout'); ?>" title="Log out from System" data-toggle="tooltip"><li><i class="fa fa-sign-out fa-6"></i></li></a>
	    </ul>
	  </div>
	</div>
	<div class="col-md-3 col-md-offset-9 col-xs-12 float_form affix">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="h4" id="title"></span>
				<span class="pull-right cls"><i class="fa fa-times"></i></span>
			</div>
			<div class="panel-body">
				<form id="bengkel_data" role="form">
					<div class="form-group">
						<label for="name">Nama Bengkel <span id="code"></span>:</label>
						<input type="text" name="name" id="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="company">Nama Perusahaan:</label>
						<input type="text" name="company" id="company" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="contact">Kontak:</label>
						<input type="number" name="contact" id="contact" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" name="email" id="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="location">Lokasi:</label>
						<input type="text" name="location" id="location" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="location">Koordinat:</label>
						<input type="text" name="latlng" id="latlng" class="form-control" readonly>
					</div>
					<input type="text" name="id_marker" id="id_marker" class="input hide">
					<input type="text" name="current_loc" id="current_loc" class="input hide">
					<input type="submit" name="submit" value="SIMPAN" id="submit" class="btn btn-primary btn-block">
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div id="map"></div>
	</div>
</div>
<div class="no"></div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&callback=nadhifMap" async defer></script>
<script src="<?php echo base_url('assets/func.js');?>"></script>
<script src="<?php echo base_url('assets/marker.js');?>"></script>