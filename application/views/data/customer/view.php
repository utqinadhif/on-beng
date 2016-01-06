<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
  <div class="panel-heading">
    Data Customer
  </div>
  <div class="panel-body">
    <form id="search" action="<?php echo base_url('data_customer/view'); ?>" class="form-inline pull-right">
      <div class="input-group">
        <input class="form-control" type="text" value="<?php echo isset($key) ? $key : null; ?>" placeholder="Search" aria-describedby="rst">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
      </div>
      <span class="btn btn-default rst"><i class="fa fa-times"></i></span>
    </form>
    <div class="clearfix"></div>
    <hr class="devider">
    <?php
    if($total>0)
    {
      ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Username or Email</th>
              <th>Contact</th>
              <th>Location</th>
              <th>Created</th>
              <th>Updated</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $current_number = $num_start;
            foreach ($data->result() as $key => $value)
            {
              $profile = json_decode($value->profile);
              $latlng  = json_decode($value->latlng);
              ?>
              <tr>
                <td><?php echo $num_start++; ?></td>
                <td><?php echo $profile->name; ?></td>
                <td><?php echo $value->username; ?></td>
                <td><?php echo $profile->contact; ?></td>
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Lat</th>
                      <td><?php echo $latlng->lat; ?></td>
                    </tr>
                    <tr>
                      <th>Lng</th>
                      <td><?php echo $latlng->lng; ?></td>
                    </tr>
                  </table>
                  "><?php echo $profile->location; ?></span>
                </td>
                <td><?php echo $value->created; ?></td>
                <td><?php echo $value->updated; ?></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <?php
    }else{
      echo alert('No data found');
    }
    ?>  
  </div>
  <div class="panel-footer">
    <span class="pull-left">Total : <?php echo $total;?></span>
    <span class="pull-right" style="height:0px"><?php echo $paging;?></span>
    <div class="clearfix"></div>
  </div>
</div>