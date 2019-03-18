<?php
	header('Content-Type: application/json');
	require('config.php');
	$q=$_GET["q"];
	if ($q=="North Area") {
		$q=1;
	}
	elseif ($q=="South Area") {
		$q=2;
	}
	$querysearch="SELECT gid,nama,ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat FROM titik where obj_id = '$q'";
	$hasil=pg_query($querysearch);
	while($row = pg_fetch_array($hasil)){
		$gid=$row['gid'];
		$nama=$row['nama'];
		$longitude=$row['lng'];
		$latitude=$row['lat'];
		$dataarray[]=array('gid'=>$gid,'nama'=>$nama,'longitude'=>$longitude, 'latitude'=>$latitude);
	}
	echo json_encode ($dataarray);
?>