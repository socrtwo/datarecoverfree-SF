<?php
require_once('includes/configure.php');

//echo 'Message';
$rname = mysql_real_escape_string($_POST['rname']);
$remail = mysql_real_escape_string($_POST['remail']);
$rpassword = mysql_real_escape_string($_POST['rpassword']);
$rcpassword = mysql_real_escape_string($_POST['rcpassword']);
$emailerror = '';

function validateEmail($email)
{
   if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email ))
	  return true;
   else
	  return false;
}

if(strlen($rname) < 1  || strlen($rpassword) < 1 || strlen($rcpassword) < 1 || validateEmail($remail) == FALSE){
	$emailerror = '<b>Error:</b> <br />';	
	
	if(empty($rname)){
		$emailerror .= 'Enter Name <br />';	
	}
	
	if(empty($rpassword)){
		$emailerror .= 'Enter Password <br />';
	}

	if(empty($rcpassword)){
		$emailerror .= 'Enter Confirm Password <br />';
	}
	
	if($rpassword != $rcpassword){
		$emailerror .= 'Passwords are not same <br />';
	}
	
	if(validateEmail($remail) == FALSE){
		$emailerror .= 'Enter valid Email Address <br />';
	}
}else{
	$sql_check = mysql_query("select * from `users` where `email`='$remail'");
	if(mysql_num_rows($sql_check)>0){
		$emailerror = "Email address is already registered with us";
	}else{
		$sql_account = mysql_query("insert into `users` (`name`, `email`, `password`) values ('$rname', '$remail', '$rpassword')");
		//$emailerror = 'Success';
		if($sql_account == '1')
			$emailerror = "<script type='text/javascript'>$('#rname').val('');$('#remail').val('');$('#rpassword').val('');$('#rcpassword').val('');</script><span>Thanks for registering with us. <br /> You can now login into your account</span>";
	}
}
echo $emailerror;
?>