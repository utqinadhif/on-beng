<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$query 	= $this->db->get("beo_bengkel");
?>
<script>
	var data = <?php
	foreach ($query->result() as $row)
	{
		$loc            = json_decode($row->latlng);
		$loc->id_marker = $row->id_marker;
		$result[]       = $loc;
	}
	echo !empty($result) ? json_encode($result) : '{}';
	?>;
</script>