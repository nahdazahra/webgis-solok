<?php
	header('Content-Type: application/json');
	require('config.php');
	$q=$_POST["routes"];
	$querysearch="SELECT gid,nama,ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat FROM titik where obj_id = '$q' order by gid";
	$hasil=pg_query($querysearch);
	while($row = pg_fetch_array($hasil)){
		$gid=$row['gid'];
		$nama=$row['nama'];
		$longitude=$row['lng'];
		$latitude=$row['lat'];
		

		$latlong="SELECT gid,nama,ST_X(ST_Centroid(geom)) AS lng, ST_Y(ST_CENTROID(geom)) As lat FROM titik where nama = '$nama'";
		$hasil2=pg_query($latlong);
		$row2 = pg_fetch_row($hasil2);

		$arr = array('lat' =>$row2['lat'] , 'long' => $row2['lng'] );

		$dataarray[]=array('gid'=>$gid,'nama'=>$nama,'longitude'=>$longitude, 'latitude'=>$latitude, 'latlong'=>$arr);
	}
	echo json_encode ($dataarray);
?>