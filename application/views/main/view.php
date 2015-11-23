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
        <a href="" class="load_url" data-load="<?php echo base_url('main/load/1'); ?>" tit="Information about how to use this application" title="Information about how to use this application" data-toggle="tooltip"><li><i class="fa fa-info fa-6"></i></li></a>
      </ul>
      <ul>
        <a href="" class="load_url" data-load="<?php echo base_url('main/load/2'); ?>" tit="Information about this application" title="Information about this application" data-toggle="tooltip"><li><i class="fa fa-question fa-6"></i></li></a>
      </ul>
      <ul>
        <a href="" class="open_hide" title="Sign In into System" data-toggle="tooltip"><li><i class="fa fa-sign-in fa-6"></i></li></a>
      </ul>
    </div>
  </div>
  <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1 login affix">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <span class="h4">Log In</span>
      </div>
      <div class="panel-body">
        <form id="login" role="form">
          <div class="form-group">
            <label for="user">User:</label>
            <input type="text" name="user" id="user" class="form-control" placeholder="User">
          </div>
          <div class="form-group">
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" class="form-control" placeholder="Password">
          </div>
          <input type="submit" name="submit" value="Log In" id="submit" class="btn btn-primary btn-block">
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div id="map"></div>
  </div>
</div>
<div class="no"></div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <span class="h4 modal-title title"></span>
      </div>
      <div class="modal-body">
        <span class="content"></span>
      </div>
    </div>
  </div>  
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&callback=nadhifMap" async defer></script>
<script src="<?php echo base_url('assets/func.js');?>"></script>
<script src="<?php echo base_url('assets/main.js'); ?>"></script>