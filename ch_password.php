<?php

require('config.php');

//check if form is submitted
if (isset($_POST['ch_pass'])) {
    $upwd = $con->escapeString($_POST['password']);
    $cpwd = $con->escapeString($_POST['cpassword']);
    echo $con->changePass($upwd, $cpwd);
}
?>