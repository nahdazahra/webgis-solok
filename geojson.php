<?php
	header('Content-Type: application/json');
	require('config.php');
	$sql="SELECT st_asgeojson(loc.geom) As geometry, gid, nama FROM titik As loc";
	$geojson = array(
		'type' => 'FeatureCollection',
		'features' => array()
		);
	$result=pg_query($sql);
	while($edge=pg_fetch_assoc($result)){
	$feature = array(
		'type' => 'Feature',
		'geometry' => json_decode($edge['geometry'], true),
		'properties' => array(
		'gid' => $edge['gid'],
		'nama' => $edge['nama']
		)
	);
	array_push($geojson['features'], $feature);
	}
	echo json_encode($geojson);
?>