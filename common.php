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
  
  $njop = $_GET["njop"];
  // desa
  if (isset($_GET['q'])){
    $sql = "SELECT gid, nama, st_astext(geom) As area, obj_id, njop FROM znt_desa WHERE obj_id = '$q'";
    if(isset($_GET['desa']) && $_GET['desa']){
      $sql.=" AND nama = '$desa'";
    }
    $result = pg_query($sql);
    while($row = pg_fetch_array($result)){
      $gid=$row['gid'];
      $nama=$row['nama'];
      $area=$row['area'];
      $njop=$row['njop'];
      $dataarray[]=array('gid'=>$gid,'nama'=>$nama,'area'=>$area,'njop'=>$njop);
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