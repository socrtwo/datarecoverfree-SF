<?php
require('includes/configure.php');

$action = isset($_POST['action'])?$_POST['action']:'';
if($action=='subm'){
	$email = isset($_POST['email'])?$_POST['email']:'';
	$ip=$_SERVER['REMOTE_ADDR'];
	
	$sql_1 = mysql_query("select * from newsletter where email = '$email'");
	if(mysql_num_rows($sql_1) > 0){
		echo 'Your email is already in our list.';		
	}else{
	$sql_2 = mysql_query("insert into newsletter (`email`,`ipaddress`) values ('$email','$ip')");
	if($sql_2)
		echo 'success';
	else
		echo 'Unable to update. Please try later.';
	}
}
?>