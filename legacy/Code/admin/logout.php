<?php
	require('includes/common.php');
	
	session_unregister("admin_id_Sq");
	header('Location: login.php');
?>