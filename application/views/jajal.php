<h1>Subscriber management</h1>
<?php
// echo link_tag('https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css');
echo link_tag('https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css');
echo $this->table->generate();
?>
<script src="<?php echo base_url('assets/data-tables/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/data-tables/js/dataTables.bootstrap.min.js');?>"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#big_table').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "<?php echo base_url('jajal/datatable'); ?>",
      "columnDefs": [ {
            "targets": 0,
            "data": null,
            "defaultContent": "<span class='detail' data-toggle='popover' data-trigger='hover' data-html='true' data-placement='bottom' title='' data-content='<table><tr><th>Lat</th><td>Lat</td></tr><tr><th>Lng</th><td>Lat</td></tr></tsble>'>"+9+"</span>"
        } ],
      "fnDrawCallback": function (){
        $(".detail").popover();
      },
    });
  });
</script>