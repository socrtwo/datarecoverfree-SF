<?php
define('TITLE','Category');
require('includes/header.php');
require_once('classes/Helper.php');

$id = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):'';
//echo $id.'hi';
$has_subcategories = true;
$sql1 = mysql_query("select * from `categories` where `id`='$id'");
if(mysql_num_rows($sql1)>0){
	$res1 = mysql_fetch_array($sql1);
	$sql2 = mysql_query("select * from `categories` where `parentid`='$res1[id]'");
	if(mysql_num_rows($sql2)>0){
		$has_subcategories = true;
	}else{
		$has_subcategories = false;		
	}
}else{
	header('Location: '.URL.'home/');
}
?>

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">
<?php require('includes/fixbanner.php'); ?>

<div class="fixbox">
<div class="breadcrumb">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="javascript:void(0);"><?php echo $res1['name']; ?></a></div>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1><?php echo $res1['name']; ?></h1>
</div>

<?php if($has_subcategories){ ?>

<div class="subbox1">
<ul>
<?php while($res2 = mysql_fetch_array($sql2)){ 
	echo '<li><a href="'.URL.'sub-category/'.strtolower(str_replace(' ','-',$res2['name'])).'/'.$res2['id'].'/">'.$res2['name'].'</a></li>';
} ?>
</ul>
</div>

<?php if(mysql_num_rows($sql2)>40){ ?>
<div class="mlink">
<a href="#" class="more"><img src="<?php echo URL; ?>images/more_subcategory.png" width="165" height="26" /></a>
</div>
<?php } ?>

<?php }else{ ?>

<div class="subbox1">
<div class="nop">No Sub Categories or Products in this Section</div>
</div>

<?php } ?>

</div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<?php require('includes/footer.php'); ?>