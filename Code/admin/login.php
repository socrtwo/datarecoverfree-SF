<?php
	require('includes/common.php');
       if(isset($_SESSION['admin_id_Sq'])){ 
		header('Location: main.php');
          }	
	$action = isset($_POST['action'])?mysql_real_escape_string($_POST['action']):'';
	if($action=='login'){
		$username = isset($_POST['username'])?mysql_real_escape_string($_POST['username']):'';
		$password = isset($_POST['password'])?mysql_real_escape_string($_POST['password']):'';
		$check_query = mysql_query("select * from admin_users where username='$username' and password='$password'");
		if(mysql_num_rows($check_query)>0){
			if($check_array=mysql_fetch_array($check_query)){
					$_SESSION['admin_id_Sq'] = $check_array['id'];
					$_SESSION['admin_name_Sq'] = $check_array['username'];
					header('Location: main.php');
				}else{
					header('Location: login.php?error_msg=Your Login is blocked');
				}
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login Area - S2 Services</title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="mainbox">
  <div class="box1">
    <p>Please log in to Admin Area...</p>
  </div>
  <div class="border1">&nbsp;</div>
  <div class="formhold">
    <div class="formbox">
      <form action="login.php" method="post">
        <input type="hidden" name="action" value="login" />
        <p>User Name</p>
        <input type="text" name="username">
        <p>Password</p>
        <input type="password" name="password">
        <div class="buttons">
          <input type="submit" value=" " class="submitclass"  />
          <input type="reset" value=" " name="reset" class="resetclass" />
        </div>
      </form>
    </div>
  </div>
  <div class="link">
    <p>Copyright &copy; <?php echo date('Y'); ?>.<a href="#">S2 Services</a></p>
  </div>
</div>
</body>
</html>
