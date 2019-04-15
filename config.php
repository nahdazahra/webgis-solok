<?php
	$host = "localhost";
	$user = "postgres";
	$pass = "nahda";
	$port = "5432";
	$dbname = "webgis-solok";
	$conn = pg_connect("host=".$host." port=".$port."  dbname=".$dbname." user=".$user." password=".$pass) or  die("Koneksi gagal");
?>