<?php 
define('URL','http://localhost/projects/s2services/');
define('DB','stwoservices');
define('DB_HOST','localhost'); 
define('DB_USER','root'); 
define('DB_PASSWORD','');

$db_connect = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
$select_db = mysql_select_db(DB);

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($link,DB);

@session_start();
?>