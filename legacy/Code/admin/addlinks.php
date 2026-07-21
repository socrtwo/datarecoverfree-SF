<?php
define('TITLE','Add Custom Links Page');
require('includes/header.php');

$checker = isset($_POST['checker'])?mysql_real_escape_string($_POST['checker']):'';	

if($checker == 'tester'){
	$name = isset($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
	$link = isset($_POST['link1'])?mysql_real_escape_string($_POST['link1']):'';	
	
    $insert_sql = mysql_query("INSERT INTO `links` (`id`, `name`, `link`) VALUES (NULL, '$name', '$link')");
	//echo $update_sql;
	
	if($insert_sql == '1'){
		header('Location: links.php?info=Updated Successfully');
	}else{
		header('Location: addlinks.php?info=Error in updation. Please try again');
	}
}
?>
<div id="admincontentarea">
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<form action="addlinks.php" name="add_links" method="post" onsubmit="return validate1();">
<input type="hidden" value="tester" name="checker" />

<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright"><input type="text" name="name" id="name" value="" /></div></div>
<div class="fieldholder"><div class="fleft"><span>Link :</span></div><div class="fright"><input type="text" name="link1" id="link1" value="" /></div></div>
<div class="fieldholder"><div class="fleft"><span>&nbsp;</span></div><div class="fright"><input type="submit" value="Update" /></div></div>
</form>
<script type="text/javascript">
function validate1()
{
	var frm = document.add_links;
	var name = frm.name.value;
	var link1 = frm.link1.value;	
	
	//alert(name);

	if(name=='' || link1=='')
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