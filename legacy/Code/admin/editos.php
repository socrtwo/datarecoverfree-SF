<?php
require('includes/common.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$eid = isset($_POST['eid'])?mysql_real_escape_string($_POST['eid']):'';		
	$name = isset($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
	
	$insert_sql = mysql_query("UPDATE `os` SET `name` = '$name' WHERE `id` ='$eid'");
	
	if($insert_sql == '1')
		header('Location: os.php?info=Category Updated Successfully');
}else{
	$id = isset($_GET['id'])?mysql_real_escape_string($_GET['id']):'';
	if($id == ''){
		header('Location: os.php');
	}
	else{
		$select_sql = mysql_query("select * from os where id='$id'");
		//print_r($select_sql);
		$res_sql = mysql_fetch_array($select_sql);
	
		//print_r($res_sql);
		if($res_sql==''){
		header('Location: os.php');
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Details - Operating System</title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>

</head>
<body bgcolor="#FFFFFF">
<?php require('includes/header.php'); ?>
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="editos.php" name="edit_os" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />
<input type="hidden" value="<?php echo $id; ?>" name="eid" />

<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright"><input type="text" name="name" id="name" value="<?php echo $res_sql['name']; ?>" /></div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.edit_os;
	var name = frm.name.value;
	
	if(name=='')
	{
		alert('All the fields are required');
		return false;		
	}
	else
	{
		return true;
	}
}
</script>
</div>
</div>
</div>
</body>
</html>
