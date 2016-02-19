<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
  <div class="panel-heading">Data Request Customer</div>
  <div class="panel-body">
    <form action="<?php echo base_url('data_order/view'); ?>" class="form-inline pull-right" method="POST">
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
                <td>
                  <span class="detail" data-toggle="popover" data-trigger="hover click" data-html="true" data-placement="bottom" title="" data-content="
                  <table>
                    <tr>
                      <th>Date</th>
                      <td><?php echo $value->created; ?></td>
                    </tr>
                  </table>
                  "><?php echo $type; ?></span>
                </td>
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
                <td class="status"><?php echo ucfirst($status_text['status'][$value->status]); ?></td>
                <td>
                  <select class="form-control change-status" rel="<?php echo $value->id;?>">
                    <option>Choose</option>
                    <option disabled="true">_________</option>
                    <?php
                    foreach ($status_text['status_v'][$value->status] as $vs)
                    {
                      ?>
                      <option value="<?php echo $vs; ?>"><?php echo ucfirst($status_text['status'][$vs]); ?></option>
                      <?php                   
                    }
                    ?>
                  </select>
                </td>
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
<script src="<?php echo base_url('assets/js/data_order.js'); ?>"></script>