<?php
	header('Content-Type: application/json');
	require('config.php');
	$sql="SELECT st_asgeojson(area.geom) As geometry, gid, nama, obj_id, njop FROM znt_desa As area";
	$geojson = array(
		'type' => 'FeatureCollection',
		'features' => array()
		);
	$result=pg_query($sql);
	while($edge=pg_fetch_assoc($result)){
		$points = [];
		$geom = json_decode($edge['geometry'], true);
		foreach ($geom['coordinates'][0][0] as $val) {
			$arr = [
				'x' => $val[0],
				'y' => $val[1]
			];
			$points[] = $arr;
		}
		$feature = array(
			'type' => 'Feature',
			'points' => $points,
			'geometry' => json_decode($edge['geometry'], true),
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