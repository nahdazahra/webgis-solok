<?php
  //koneksi db
  $host = "localhost";
	$user = "postgres";
	$pass = "nahda";
	$port = "5432";
	$dbname = "webgis-solok";
	$db = pg_connect("host=".$host." port=".$port."  dbname=".$dbname." user=".$user." password=".$pass) or  die("Koneksi gagal");
	include_once('userclass.php');
	$con = new UserClass($db);
?>