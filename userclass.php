<?php
class UserClass
{
	private $db;
	
	// constructor
	function __construct($db)
	{
		$this->db = $db;
	}
	
	function userLogin($password)
	{
		$password = md5($password);
    $result = pg_query($this->db, "SELECT * FROM public.admin WHERE passwd = '" . $password . "'");
		if (pg_num_rows($result) > 0) { //success
      @session_start();
      $row = pg_fetch_assoc($result);
      $_SESSION['usr_name'] = $row['nama'];
      echo 'asdf'; 
      header('Location: dashboard.php');
		} else { //fail
      echo 'Login gagal!';
      return false;
    }
  }

  function userLogout()
  {
    session_destroy();
    unset($_SESSION['usr_name']);
    header('Location: index.php');
    return;
  }

  function escapeString($str) {
    return pg_escape_string($str);
  }
  
  function changePass($upwd, $cpwd)
  {
    if ($upwd != $cpwd) {
      $error = true;
      $cpassword_error = "Password tidak cocok";
    }
    $password = md5($upwd); //encrypt the password before saving in the database
    
    if (!$error) {
      $query = "UPDATE public.admin SET passwd = '$password'";
      if(pg_query($this->db, $query)) {
        $message = "Password berhasil diubah";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header('Location: dashboard.php');
      } else {
        $message = "Gagal mengubah password";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header('Location: dashboard.php');
      }
    }
  }
}
?>