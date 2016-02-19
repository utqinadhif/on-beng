<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
  <div class="panel-heading">
    Data Bengkel
  </div>
  <div class="panel-body">
    <form action="<?php echo base_url('data_bengkel/view'); ?>" class="form-inline pull-right" method="POST">
      <div class="input-group">
        <input class="form-control" name="search" type="text" value="<?php echo isset($key) ? $key : null; ?>" placeholder="Search" aria-describedby="rst">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default" name="submit" value="1"><i class="fa fa-search"></i></button>
          <button type="sumbit" class="btn btn-default rst" name="reset" value="1"><i class="fa fa-times"></i></button>
        </span>
      </div>
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
              <th>Bengkel Name</th>
              <th>Company</th>
              <th>Contact</th>
              <th>Email</th>
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
                <td><?php echo $profile->company; ?></td>
                <td><?php echo $profile->contact; ?></td>
                <td><?php echo $profile->email; ?></td>
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