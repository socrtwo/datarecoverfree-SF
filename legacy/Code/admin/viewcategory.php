<?php
define('TITLE','View Category Page');
require('includes/header.php');

$id = isset($_GET['id'])?mysql_real_escape_string($_GET['id']):'';	

if($id != ''){
    $sql = mysql_query("select * from `categories` where `id`='$id'");
	//echo $update_sql;
	
	if(mysql_num_rows($sql)>0){
		$res = mysql_fetch_array($sql);
		$id = $res['id'];
		$name = $res['name'];
		$parentid = $res['parentid'];
		$sql2 = mysql_query("select * from `categories` where `id`='$parentid'");
		$res2 = mysql_fetch_array($sql2);
		$parentname = $res2['name'];
	}else{
		header('Location: categories.php?info=Invalid Category Id');	
	}
}else{
	header('Location: categories.php?info=Invalid Category Id');	
}
?>
<style type="text/css">
.formholder .fieldholder .fleft span{
	margin-top:0px;
}
</style>
<div id="admincontentarea">
<div id="admintablewrapper">
<div class="formholder1">
<div class="formholder">
<div class="fieldholder"><div class="fleft"><span>Id :</span></div><div class="fright"><?php echo $id; ?></div></div>
<div class="fieldholder"><div class="fleft"><span>Name :</span></div><div class="fright"><?php echo $name; ?></div></div>
<div class="fieldholder"><div class="fleft"><span>Parent Id :</span></div><div class="fright"><?php echo $parentid; ?></div></div>
<div class="fieldholder"><div class="fleft"><span>Parent Name :</span></div><div class="fright"><?php echo $parentname; ?></div></div>
</div>
</div>
</div></div>
<?php require('includes/footer.php'); ?>