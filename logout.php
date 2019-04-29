<?php
@session_start();
include_once('config.php');
$con->userLogout();
header('Location: index.php');
?>