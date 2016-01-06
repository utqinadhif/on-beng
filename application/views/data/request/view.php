<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
  <form id="search" action="<?php echo base_url('data_request/view'); ?>">
    <div class="pull-right form-inline">
      <span class="btn btn-default rst"><i class="fa fa-times"></i></span>
      <input class="form-control" type="text" value="<?php echo isset($key) ? $key : null; ?>" placeholder="Search">
    </div>
  </form>
  <div class="panel-heading">Data Request Customer</div>
  <div class="panel-body">
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
              <th>Email</th>
              <th>Contact</th>
              <th>Detail Address</th>
              <th>Bengkel Ordered</th>
              <th>Process</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $current_number = $num_start;
            foreach ($data->result() as $key => $value)
            {
              $profile_customer = json_decode($value->profile_customer);
              $latlng_customer  = json_decode($value->latlng_customer);
              $profile_bengkel  = json_decode($value->profile_bengkel);
              ?>
              <tr>
                <td><?php echo $num_start++; ?></td>
                <td><?php echo $profile_customer->name; ?></td>
                <td><?php echo $value->username; ?></td>
                <td><?php echo $profile_customer->contact; ?></td>
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Lat</th>
                      <td><?php echo $latlng_customer->lat; ?></td>
                    </tr>
                    <tr>
                      <th>Lng</th>
                      <td><?php echo $latlng_customer->lng; ?></td>
                    </tr>
                  </table>
                  "><?php echo $profile_customer->location; ?></span>
                </td>
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Company</th>
                      <td><?php echo $profile_bengkel->company;?></td>
                    </tr>
                    <tr>
                      <th>Contact</th>
                      <td><?php echo $profile_bengkel->contact;?></td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td><?php echo $profile_bengkel->email;?></td>
                    </tr>
                  </table>
                  "><?php echo $profile_bengkel->name;?></span>
                </td>
                <td>Link</td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <?php
    }
    ?>  
  </div>
  <div class="panel-footer">
    <span class="pull-left">Total : <?php echo $total;?></span>
    <span class="pull-right" style="height:0px"><?php echo $paging;?></span>
    <div class="clearfix"></div>
  </div>
</div>
