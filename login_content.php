<?php

require('config.php');

//check if form is submitted
if (isset($_POST['login_user'])) {
    $upwd = $con->escapeString($_POST['password']);
    echo $con->userLogin($upwd);
}
?>
