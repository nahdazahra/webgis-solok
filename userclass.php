<?php
class UserClass
{
	private $db;
	
	// constructor
	function __construct($db)
	{
		$this->db = $db;
	}
	
  function userRegis($unip, $unama, $uemail, $upwd, $cpwd)
  {
    if (!preg_match("/^[a-zA-Z ]+$/",$unama)) {
      $error = true;
      $name_error = "Nama hanya mengandung huruf atau spasi";
    }
    if ($upwd != $cpwd) {
      $error = true;
      $cpassword_error = "Password tidak cocok";
    }
    
    // first check the database to make sure 
    // a user does not already exist with the same nip and/or email
    $user_check_query = "SELECT * FROM public.admin WHERE nip='$unip' OR email='$email' LIMIT 1";
    $result = pg_query($this->db, $user_check_query);
    $user = pg_fetch_assoc($result);
    $password = md5($upwd); //encrypt the password before saving in the database

    if ($user) { // if user exists
      if ($user['nip'] === $unip) {
        $error = true;
        $regnip_error = "NIP sudah terdaftar";
      }
    
      if ($user['email'] === $uemail) {
        $error = true;
        $email_error = "Email sudah terdaftar";
      }
      
    }

    if (!$error) {
      $query = "INSERT INTO public.admin (nip, nama, email, passwd) VALUES('$unip','$unama','$uemail', '$password')";
      if(pg_query($this->db, $query)) {
        @session_start();
        $_SESSION['usr_id'] = $row['email'];
        $_SESSION['usr_name'] = $row['nama'];
        header('Location: dashboard.php');
      } else {
        echo "Registrasi gagal";
        $errormsg = "Registrasi gagal";
      }
    }
  }

	function userLogin($email, $password)
	{
		$password = md5($password);
    $result = pg_query($this->db, "SELECT * FROM public.admin WHERE email = '" . $email . "' and passwd = '" . $password . "'");
		if (pg_num_rows($result) > 0) { //success
      @session_start();
      $row = pg_fetch_assoc($result);
			$_SESSION['usr_id'] = $row['email'];
      $_SESSION['usr_name'] = $row['nama'];
      echo 'asdf'; 
      header('Location: dashboard.php');
		} else { //fail
      echo 'knp nih';
      return false;
    }
  }

  function userLogout()
  {
    session_destroy();
    unset($_SESSION['usr_id']);
    unset($_SESSION['usr_name']);
    header('Location: dashboard.php');
    return;
  }

  function escapeString($str) {
    return pg_escape_string($str);
  }
}
?>