<?php
define('TITLE','Category Index Page');
require('includes/header.php'); 
?>

<!-- Start-->
<div id="content_holder">
<!-- Start-->
<div class="content_center content_center1">
<div class="fixbox1">
<div class="breadcrumb1">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="javascript:void(0);">Category Index</a></div>
<div class="headbox">
<h3><font color="#32507d"><strong>Category Index</strong></font></h3>
</div>
<div class="allcategory">

<?php 
$sql1 = mysql_query("select * from `categories` where `parentid`='0'");
if(mysql_num_rows($sql1)>0){
	while($res1 = mysql_fetch_array($sql1)){
		echo '<div class="innersub_div">';
		echo '<div class="cbox2">';
		echo '<h2><a href="'.URL.'category/'.strtolower(str_replace(' ','-',$res1['name'])).'/'.$res1['id'].'/">'.$res1['name'].'</a></h2>';
		echo '</div><div class="cbox3"><ul>';
		
		$sql2 = mysql_query("select * from `categories` where `parentid`='$res1[id]'");
		if(mysql_num_rows($sql2)>0){
			while($res2 = mysql_fetch_array($sql2)){
				echo '<li><a href="'.URL.'sub-category/'.strtolower(str_replace(' ','-',$res2['name'])).'/'.$res2['id'].'/">'.$res2['name'].'</a></li>';
			}
		}else{
			echo '<li>No Sub Categories in this Category</li>';
		}
		
		echo '</ul></div></div>';
	} 
}else{
	echo '<div class="info11">Currently there are no categories present</div>';
}
?>
</div>

</div></div></div>
<!-- End-->

<?php require('includes/footer.php'); ?>