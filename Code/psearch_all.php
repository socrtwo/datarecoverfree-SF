<?php
define('TITLE','Popular Search');
require('includes/header.php');
require_once('classes/Helper.php');

$sql1 = mysql_query("select DISTINCT `os` from `softwares` where `os`!='NA' AND `os`!='Not available' AND `os`!='Not applicable' AND `os`!='0' order by id desc");
if(mysql_num_rows($sql1)>0){
	$res1 = mysql_fetch_array($sql1);
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
<div class="breadcrumb">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="javascript:void(0);">Popular Search</a></div>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1>Popular Search</h1>
</div>


<div class="subbox1">
<ul>
<?php while($res2 = mysql_fetch_array($sql1)){ 
	echo '<li><a href="'.URL.'popularsearch/' . strtolower(str_replace(',','=',str_replace(' ','-',$res2['os']))) . '/">'.$res2['os'].'</a></li>';
} ?>
</ul>
</div>

</div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<?php require('includes/footer.php'); ?>