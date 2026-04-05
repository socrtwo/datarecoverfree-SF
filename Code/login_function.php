<?php
require_once('includes/configure.php');

//echo 'Message';
$lemail = mysql_real_escape_string($_POST['lemail']);
$lpassword = mysql_real_escape_string($_POST['lpassword']);
$emailerror = '';

function validateEmail($email)
{
   if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email ))
	  return true;
   else
	  return false;
}

if(strlen($lpassword) < 1 || validateEmail($lemail) == FALSE){
	$emailerror = '<b>Error:</b> <br />';	
	
	if(validateEmail($lemail) == FALSE){
		$emailerror .= 'Enter valid Email Address <br />';
	}

	if(empty($lpassword)){
		$emailerror .= 'Enter Password <br />';
	}
}else{
	$sql_check = mysql_query("select * from `users` where `email`='$lemail' and `password`='$lpassword'");
	if(mysql_num_rows($sql_check)>0){
		$res_check = mysql_fetch_array($sql_check);
		if($res_check['status']=='1'){
			$_SESSION['s2id']=$res_check['id'];
			$_SESSION['s2name']=$res_check['name'];
			$emailerror = "<script type='text/javascript'>$('#lsignin').css('display','none');</script><span>Welcome back, ".$res_check['name'].". <br /><br /> Please <a href=\"#\" onclick=\"window.location.href=('".URL."home/');\">click here</a> to continue</span>";
		}else{
			$emailerror = "Your account is blocked. contact help at <a href='mailto:socrtwo@s2services.com'>socrtwo@s2services.com</a>";
		}
	}else{
		$emailerror = "Invalid Email / Password";
	}
}
echo $emailerror;
?>