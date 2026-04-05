<?php
require('includes/common.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$eid = isset($_POST['eid'])?mysql_real_escape_string($_POST['eid']):'';		
	$name = isset($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
	$parent = isset($_POST['parent'])?mysql_real_escape_string($_POST['parent']):'';	
	
	$insert_sql = mysql_query("UPDATE `categories` SET `name` = '$name', `parentid` = '$parent' WHERE `id` ='$eid'");
	
	if($insert_sql == '1')
		header('Location: categories.php?info=Category Updated Successfully');
}else{
	$id = isset($_GET['id'])?mysql_real_escape_string($_GET['id']):'';
	if($id == ''){
		header('Location: categories.php');
	}
	else{
		$select_sql = mysql_query("select * from categories where id='$id'");
		//print_r($select_sql);
		$res_sql = mysql_fetch_array($select_sql);
	
		//print_r($res_sql);
		if($res_sql==''){
		header('Location: categories.php');
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Details - Category</title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>

</head>
<body bgcolor="#FFFFFF">
<?php require('includes/header.php'); ?>
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="editcategory.php" name="edit_category" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />
<input type="hidden" value="<?php echo $id; ?>" name="eid" />

<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright"><input type="text" name="name" id="name" value="<?php echo $res_sql['name']; ?>" /></div></div>
<div class="fieldholder"><div class="fleft"><span>Parent Category :</span></div><div class="fright">
<select name="parent" id="parent">
<option value="0">No Parent</option>
<?php
$sql1 = mysql_query("select * from `categories` where `id`!='' and `parentid`='0'");
if(mysql_num_rows($sql1)){
while($res1 = mysql_fetch_array($sql1)){
	if($res_sql['name']==$res1['name']){
		
	}else{
		if($res1['id']==$res_sql['parentid']){
			echo '<option value="'.$res1['id'].'" selected="selected">'.$res1['name'].'</option>';
		}else{
			echo '<option value="'.$res1['id'].'">'.$res1['name'].'</option>';
		}
	}
?>

<?php } } ?>
</select>
</div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.edit_category;
	var name = frm.name.value;
	var parent = frm.parent.value;	
	
	if(name=='' || parent=='')
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