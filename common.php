<?php
  header('Content-Type: application/json');
  require('config.php');
  $q=$_GET["q"];
  $desa=$_GET["desa"];
  $zona=$_GET["zona"];
  // echo $zona; die();
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

    if($zona==0){
      $bawah=0;
      $atas=100000;
    }
    elseif($zona==1){
      $bawah=100000;
      $atas=200000;
    }
    elseif($zona==2){
      $bawah=200000;
      $atas=500000;
    }
    elseif($zona==3){
      $bawah=500000;
      $atas=1000000;
    }
    elseif($zona==4){
      $bawah=1000000;
      $atas=2000000;
    }
    elseif($zona==5){
      $bawah=2000000;
      $atas=5000000;
    }
    elseif($zona==6){
      $bawah=5000000;
      $atas=10000000;
    }
    elseif($zona==7){
      $bawah=10000000;
      $atas=20000000;
    }
    elseif($zona==8){
      $bawah=20000000;
    }
    // echo $zona; die();
    $result = pg_query($sql);
    while($row = pg_fetch_array($result)){
      if($zona != ''){
        // echo $atas, $bawah; die();
        if($row['njop']<=$atas && $row['njop']>$bawah){
          $gid=$row['gid'];
          $nama=$row['nama'];
          $area=$row['area'];
          $njop=$row['njop'];
          $dataarray[]=array('gid'=>$gid,'nama'=>$nama,'area'=>$area,'njop'=>$njop);
        }
      }
      else{
        $gid=$row['gid'];
        $nama=$row['nama'];
        $area=$row['area'];
        $njop=$row['njop'];
        $dataarray[]=array('gid'=>$gid,'nama'=>$nama,'area'=>$area,'njop'=>$njop);
      }
    }
    
    $sql = "SELECT DISTINCT nama FROM znt_desa WHERE obj_id = '$q' ORDER BY nama ASC";
    $result2 = pg_query($sql);
    while($row2 = pg_fetch_array($result2)){
      $nama=$row2['nama'];
      $dataarray2[]=array('nama'=>$nama);
    }
    echo json_encode (array('list'=>$dataarray, 'nama'=>$dataarray2));
  }

?>