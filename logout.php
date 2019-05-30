<?php
@session_start();
include_once('config.php');
$con->userLogout();
header('Location: main.php');
?>