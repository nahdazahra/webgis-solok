<?php
	header('Content-Type: application/json');
	require('config.php');
	$q=$_POST["routes"];
	$querysearch="SELECT gid,nama,ST_Area(geom) As area FROM znt_desa where obj_id ='$q' order by gid";
	$hasil=pg_query($querysearch);
	echo json_encode ($dataarray);
?>