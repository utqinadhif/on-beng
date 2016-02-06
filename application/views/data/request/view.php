<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
  <div class="panel-heading">Data Request Customer</div>
  <div class="panel-body">
    <form id="search" action="<?php echo base_url('data_request/view'); ?>" class="form-inline pull-right">
      <div class="input-group">
        <input class="form-control" type="text" value="<?php echo isset($key) ? $key : null; ?>" placeholder="Search" aria-describedby="rst">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          <span class="btn btn-default rst"><i class="fa fa-times"></i></span>
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
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Bengkel Ordered</th>
              <th>Location Order</th>
              <th>Type</th>
              <th>Damage</th>
              <th>Status</th>
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
              $latlng_bengkel   = json_decode($value->latlng_bengkel);
              $latlng_order     = json_decode($value->latlng_order);
              $type             = $value->type == 1 ? 'General Order' : 'Spesific Order';
              if(strlen($value->damage) > 20)
              {
                $damage = substr($value->damage, 0, 20);
                $solen  = true;
              }else {
                $damage = $value->damage;
                $solen  = false;
              }
              ?>
              <tr>
                <td><?php echo $num_start++; ?></td>
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Location</th>
                      <td><?php echo $profile_customer->location; ?></td>
                    </tr>
                    <tr>
                      <th>Lat</th>
                      <td><?php echo $latlng_customer->lat; ?></td>
                    </tr>
                    <tr>
                      <th>Lng</th>
                      <td><?php echo $latlng_customer->lng; ?></td>
                    </tr>
                  </table>
                  "><?php echo $profile_customer->name; ?></span>
                </td>
                <td><?php echo $value->username; ?></td>
                <td><?php echo $profile_customer->contact; ?></td>
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
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Lat</th>
                      <td><?php echo $latlng_order->lat; ?></td>
                    </tr>
                    <tr>
                      <th>Lng</th>
                      <td><?php echo $latlng_order->lng; ?></td>
                    </tr>
                  </table>
                  "><?php echo $value->detail_location; ?></span>
                </td>
                <td><?php echo $type; ?></td>
                <td>
                  <?php
                  if($solen)
                  {
                    ?>
                    <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                      <?php echo $value->damage ?>
                      "><?php echo $damage; ?> [...]
                    </span>
                    <?php
                    
                  }else {
                    echo $damage;
                  }
                  ?>
                </td>
                <td><?php echo $status_text[$value->status];?></td>
                <td>Link</td>
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
