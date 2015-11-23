<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$query 	= $this->db->get("beo_bengkel");
$count  = $query->num_rows();
?>
<script>
	var data = <?php
	foreach ($query->result() as $row)
	{
		$loc            = json_decode($row->location);
		$loc->id_marker = $row->id_marker;
		$result[]       = $loc;
	}
	echo !empty($result) ? json_encode($result) : '{}';
	?>;
	var base_url  = '<?php echo base_url(); ?>';
	var currentId = <?php echo $count > 0 ? $count : 0; ?>;
</script>