<?php
  header('Content-Type: application/json');
  require('config.php');
  $q=$_GET["q"];
  $desa=$_GET["desa"];
  // kecamatan
  if ($q=="LUBUK SIKARAH") {
		$q=1;
	}
	elseif ($q=="TANJUNG HARAPAN") {
		$q=2;
  }
  
  // desa
  if (isset($_GET['q'])){
    $sql = "SELECT nama, st_astext(geom) As area, obj_id FROM znt_desa WHERE obj_id = '$q'";
    if(isset($_GET['desa']) && $_GET['desa']){
      $sql.=" AND nama = '$desa'";
    }
    $result = pg_query($sql);
    while($row = pg_fetch_array($result)){
      $nama=$row['nama'];
      $area=$row['area'];
      $dataarray[]=array('nama'=>$nama,'area'=>$area);
    }
    $sql = "SELECT DISTINCT nama FROM znt_desa WHERE obj_id = '$q'";
    $result2 = pg_query($sql);
    while($row2 = pg_fetch_array($result2)){
      $nama=$row2['nama'];
      $dataarray2[]=array('nama'=>$nama);
    }
    echo json_encode (array('list'=>$dataarray, 'nama'=>$dataarray2));
  }
  
?>