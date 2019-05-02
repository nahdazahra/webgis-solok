<?php

require('config.php');

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['reg_user'])) {
  $unip = $con->escapeString($_POST['nip']);
  $unama = $con->escapeString($_POST['nama']);
	$uemail = $con->escapeString($_POST['email']);
  $upwd = $con->escapeString($_POST['password_1']);
  $cpwd = $con->escapeString($_POST['password_2']);

  echo $con->userRegis($unip, $unama, $uemail, $upwd, $cpwd);
	//name can contain only alpha characters and space
	
}
?>