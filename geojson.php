<?php
	header('Content-Type: application/json');
	require('config.php');
	$sql="SELECT st_astext(geom) As geometry, gid, nama, obj_id, njop FROM public.znt_desa As area";
	$geojson = array(
		'type' => 'FeatureCollection',
		'features' => array()
		);
	$result=pg_query($sql);
	while($edge=pg_fetch_assoc($result)){
		$feature = array(
			'type' => 'Feature',
			'geometry' => $edge['geometry'],
			'properties' => array(
			'gid' => $edge['gid'],
			'nama' => $edge['nama'],
			'obj_id' => $edge['obj_id'],
			'njop' => $edge['njop']
			)
		);
		array_push($geojson['features'], $feature);
	}
	echo json_encode($geojson);
?>