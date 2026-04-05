<?php
require_once('includes/configure.php');

$femail = mysql_real_escape_string($_POST['femail']);
$emailerror = '';

function validateEmail($email)
{
   if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email ))
	  return true;
   else
	  return false;
}

if(validateEmail($femail) == FALSE){
	$emailerror = '<b>Error:</b> <br />';	
	
	if(validateEmail($femail) == FALSE){
		$emailerror .= 'Enter valid Email Address <br />';
	}
}else{
	$sql_check = mysql_query("select * from `users` where `email`='$femail'");
	if(mysql_num_rows($sql_check)>0){
		$res_check = mysql_fetch_array($sql_check);
		
		$subject = "Your password for S2 Services";
		
		$message = "Name: ".$res_check['name']."\n\n";
		$message .= "Email Address: ".$res_check['email']."\n\n";
		$message .= "Password: ".$res_check['password']."\n\n";
		
		$from = 'socrtwo@s2services.com';

		// From
		$headers = 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		
		$to = $femail;
		
		if(mail($to,$subject,$message,$headers)){
			$emailerror = "<script type='text/javascript'>$('#femail').val('');</script><span>Please check your email address for password</span>";
		}else{
			$emailerror = "Unable to send your password. Please try again";			
		}
	}else{
		$emailerror = "Email address is not registered with us";
	}
}
echo $emailerror;
?>