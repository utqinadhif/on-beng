<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$atts = array(
  'title'          => 'Home',
  'data-title'     => 'Home',
  'data-toggle'    => 'tooltip',
  'class'          => 'open_modal',
  'data-placement' => 'bottom'
  );
?>
<div class="container-fluid">
	<div class="col-md-6 col-sm-12 col-xs-12 menu">
		<nav class="navbar navbar-default">
		  <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#onbeng">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <?php
	      $s = $atts;
	      $s['class'] = 'navbar-brand';
	  		echo anchor(base_url('marker'), '<i class="fa fa-home"></i>On-Beng', $s);
	  		?>
	    </div>
	    <div class="boxMenu">
	    	<div class="collapse navbar-collapse" id="onbeng">
		      <ul class="nav navbar-nav">
		        <li>
			        <?php
			        $atts['title']      = 'View Data Bengkel';
			        $atts['data-title'] = 'View Data Bengkel';

			        echo anchor(base_url('data_bengkel/view'), '<i class="fa fa-database fa-6"></i> Bengkel', $atts);
			        ?>
			      </li>
			      <li>
			        <?php
			        $atts['title'] = $atts['data-title'] = 'View Data Customer';

			        echo anchor(base_url('data_customer/view'), '<i class = "fa fa-users fa-6"></i> Customer', $atts);
			        ?>
			      </li>
			      <li>
			        <?php
			        $atts['title'] = $atts['data-title'] = 'View Data Order';

			        echo anchor(base_url('data_order/view'), '<i class = "fa fa-shopping-cart fa-6"></i> Order', $atts);
			        ?>
			      </li>
			      <li>
			        <?php
			        $atts['title'] = 'Information about this application';
			        echo anchor('#', '<i class="fa fa-question fa-6"></i> About', $atts);
			        ?>
			      </li>	      
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li>
			        <?php
			        $atts['class'] = 'confirm';
			        $atts['title'] = 'Logout from system';
			        echo anchor(base_url('marker/logout'), '<i class="fa fa-sign-out fa-6"></i> Signout', $atts);
			        ?>
			      </li>
		      </ul>
		    </div>
	    </div>
		</nav>
	</div>
	<div class="col-md-3 col-md-offset-9 col-xs-12 float_form">
		<div class="panel panel-defalit">
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
						<div class="input-group">
						  <span class="input-group-addon">+62</span>
							<input type="number" name="contact" id="contact" class="form-control" required>
						</div>
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
						<label for="price">Tarif Per KM:</label>
						<div class="input-group">
						  <span class="input-group-addon">Rp.</span>
							<input type="number" name="price" id="price" class="form-control" required>
						</div>
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
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&callback=nadhifMap" async defer></script>
<script src="<?php echo base_url('assets/js/marker.js');?>"></script>