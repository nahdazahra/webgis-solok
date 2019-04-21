<?php
	header('Content-Type: application/json');
	require('config.php');
	$q=$_POST["routes"];
	$querysearch="SELECT gid,nama,ST_Area(geom) As area FROM znt_desa where obj_id = '$q' order by gid";
	$hasil=pg_query($querysearch);
	while($row = pg_fetch_array($hasil)){
		$gid=$row['gid'];
		$nama=$row['nama'];
		$luas=$row['area'];

		$latlong="SELECT gid,nama,SELECT gid,nama,ST_Area(geom) As area FROM znt_desa where nama = '$nama'";
		$hasil2=pg_query($latlong);
		$row2 = pg_fetch_row($hasil2);

		$arr = array('area' =>$row2['area']);

		$dataarray[]=array('gid'=>$gid,'nama'=>$nama,'luas'=>$luas,'latlong'=>$arr);
	}
	echo json_encode ($dataarray);
?>