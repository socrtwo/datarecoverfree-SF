<?php
define('TITLE','Add Operating System Page');
require('includes/header.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$name = isset($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
	
    $insert_sql = mysql_query("INSERT INTO `os` (`id`, `name`) VALUES (NULL, '$name')");
	//echo $update_sql;
	
	if($insert_sql == '1'){
		header('Location: os.php?info=Updated Successfully');
	}else{
		header('Location: addos.php?info=Error in updation. Please try again');
	}
}
?>
<div id="admincontentarea">
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="addos.php" name="add_os" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />

<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright">
<input type="text" name="name" id="name" value="" /></div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.add_os;
	var name = frm.name.value;
	
	//alert(name);

	if(name=='')
	{
		alert('Please enter the operating system name');
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