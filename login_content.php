<?php

require('config.php');

//check if form is submitted
if (isset($_POST['login_user'])) {
	$uemail = $con->escapeString($_POST['email']);
    $upwd = $con->escapeString($_POST['password']);
    echo $con->userLogin($uemail, $upwd);
}
?>
