<?php
define('TITLE','Add Category Page');
require('includes/header.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$name = isset($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
	$parent = isset($_POST['parent'])?mysql_real_escape_string($_POST['parent']):'';	
	
    $insert_sql = mysql_query("INSERT INTO `categories` (`id`, `name`, `parentid`) VALUES (NULL, '$name', '$parent')");
	//echo $update_sql;
	
	if($insert_sql == '1'){
		header('Location: categories.php?info=Updated Successfully');
	}else{
		header('Location: addcategory.php?info=Error in updation. Please try again');
	}
}
?>
<div id="admincontentarea">
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="addcategory.php" name="add_category" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />

<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright">
<input type="text" name="name" id="name" value="" /></div></div>
<div class="fieldholder"><div class="fleft"><span>Parent Category :</span></div><div class="fright">
<select name="parent" id="parent">
<option value="0" selected="selected">No Parent</option>
<?php
$sql1 = mysql_query("select * from `categories` where `id`!='' and `parentid`='0'");
if(mysql_num_rows($sql1)){
while($res1 = mysql_fetch_array($sql1)){
	echo '<option value="'.$res1['id'].'">'.$res1['name'].'</option>';
?>

<?php } } ?>
</select>
</div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.add_category;
	var name = frm.name.value;
	
	//alert(name);

	if(name=='')
	{
		alert('Please enter the category name');
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