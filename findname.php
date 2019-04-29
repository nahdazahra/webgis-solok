<?php
	header('Content-Type: application/json');
	require('config.php');
	$q=$_GET["q"];
	if ($q=="LUBUK SIKARAH") {
		$q=1;
	}
	elseif ($q=="TANJUNG HARAPAN") {
		$q=2;
	}
	$querysearch="SELECT gid,nama, st_astext(geom) as area FROM public.znt_desa where obj_id ='$q'";
	$hasil=pg_query($querysearch);
	while($row = pg_fetch_array($hasil)){
		$gid=$row['gid'];
		$nama=$row['nama'];
		$area=$row['area'];
		$dataarray[]=array('gid'=>$gid,'nama'=>$nama,'area'=>$area);
	}
	echo json_encode ($dataarray);
?>