<?php
require_once('configure.php');
$db_connect = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);

$select_db = mysql_select_db(DB);

if(!isset($HTTP_POST_VARS))
	$HTTP_POST_VARS = &$_POST;
if(!isset($HTTP_GET_VARS))
	$HTTP_GET_VARS = &$_GET;

	//@session_start();
	@session_register("admin_id_Sq");
	$PHP_SELF = $_SERVER['PHP_SELF'];
	
	if(basename($PHP_SELF)!='login.php' && basename($PHP_SELF)!='cron.php' && (!isset($_SESSION['admin_id_Sq']) || $_SESSION['admin_id_Sq']=='')){
		header('Location: login.php');
		exit;
	}
?>