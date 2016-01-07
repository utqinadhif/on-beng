<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
  <div class="col-md-1 col-sm-2 col-xs-4 menu affix">
    <button type="button" class="btn btn_menu">
      <i class="fa fa-bars"></i> Menu
    </button>
    <div class="item op">
      <ul>
        <?php
        $atts = array(
            'class'       => 'load_url',
            'data-load'   => base_url('main/load/1'),
            'tit'         => 'Information about how to use this application',
            'title'       => 'Information about how to use this application',
            'data-toggle' => 'tooltip'
          );
        echo anchor('', '<i class="fa fa-info fa-6"></i>', $atts);
        ?>
      </ul>
      <ul>
        <?php
        $atts['title']     = $atts['tit'] = 'Information about this application';
        $atts['data-load'] = base_url('main/load/2');

        echo anchor('', '<i class="fa fa-question fa-6"></i>', $atts);
        ?>
      </ul>
      <ul>
        <?php
        $atts['title'] = $atts['tit'] = 'Sign In into System';
        $atts['class'] = 'open_hide';

        echo anchor('', '<i class="fa fa-sign-in fa-6"></i>', $atts);
        ?>
      </ul>
    </div>
  </div>
  <script type ="text/template" class="login hide">
    <div class="panel panel-default">
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
          <input type="submit" name="submit" value="Log In" id="submit" class="btn btn-default btn-block">
        </form>
      </div>
    </div>
  </script>
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
<script src="<?php echo base_url('assets/main.js'); ?>"></script>