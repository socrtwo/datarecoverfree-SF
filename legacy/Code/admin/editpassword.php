<?php
define('TITLE','Edit Password Page');
require('includes/header.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$username = isset($_POST['username'])?mysql_real_escape_string($_POST['username']):'';
	$password = isset($_POST['password'])?mysql_real_escape_string($_POST['password']):'';	
	
    //$insert_sql = mysql_query("INSERT INTO `testimonials` (`id`, `name`, `description`) VALUES (NULL, '$name', '$description')");
	$insert_sql = mysql_query("UPDATE `admin_users` SET `username` = '$username', `password` = '$password' WHERE `id` ='1'");
	//echo $update_sql;
	
	if($insert_sql == '1')
		header('Location: editpassword.php?info=Updated Successfully');
}else{
		$select_sql = mysql_query("select * from admin_users where id='1'");
		//print_r($select_sql);
		$res_sql = mysql_fetch_array($select_sql);
	
		//print_r($res_sql);
		if($res_sql==''){
		header('Location: main.php');
	}
}
?>
<div id="admincontentarea">
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="editpassword.php" name="add_testimonials" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />
<input type="hidden" value="<?php echo $id; ?>" name="eid" />

<div class="fieldholder"><div class="fleft"><span>Username :</span></div><div class="fright">
<input type="text" name="username" id="username" value="<?php echo $res_sql['username']; ?>" /></div></div>
<div class="fieldholder"><div class="fleft"><span>Password :</span></div><div class="fright">
<input type="password" name="password" id="password" value="" /></div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.add_testimonials;
	var name = frm.username.value;
	var description = frm.password.value;
	
	//alert(name);
	//alert(description);
	
	if(name=='' || description=='')
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
</div></div>
<?php require('includes/footer.php'); ?>