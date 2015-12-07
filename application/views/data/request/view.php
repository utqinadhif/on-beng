<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
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
                    <th>Latitude</th>
                    <th>Langitude</th>
                    <th>Bengkel Ordered</th>
                    <th>Process</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $current_number = $num_start;
                  foreach ($data->result() as $key => $value)
                  {
                    $profile         = json_decode($value->profile);
                    $location        = json_decode($value->location);
                    $bengkel_profile = json_decode($value->bengkel_profile);
                    ?>
                    <tr>
                      <td><?php echo $num_start++; ?></td>
                      <td><?php echo $profile->name; ?></td>
                      <td><?php echo $profile->email; ?></td>
                      <td><?php echo $profile->contact; ?></td>
                      <td><?php echo $profile->detail_address; ?></td>
                      <td><?php echo $location->lat; ?></td>
                      <td><?php echo $location->lng; ?></td>
                      <td>
                        Name: <?php echo $bengkel_profile->name;?><br>
                        Company: <?php echo $bengkel_profile->company;?><br>
                        Contact: <?php echo $bengkel_profile->contact;?><br>
                        Email: <?php echo $bengkel_profile->email;?>
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
    </div>
  </div>
</div>