<?php
define('TITLE','Review Page');
require('includes/header.php'); 

$id = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):'';
//echo $id;
$sql_1 = mysql_query("select * from `review` where `id`='$id' and `status`='1'");
if(mysql_num_rows($sql_1)>0){
	$res_1 = mysql_fetch_array($sql_1);
	
	$sql_2 = mysql_query("select * from `softwares` where `id`='$res_1[sid]'");
	$res_2 = mysql_fetch_array($sql_2);
	
	$sql_3 = mysql_query("select `name` from `users` where `id`='$res_1[uid]'"); 
	$sres_3 = mysql_fetch_array($sql_3);
		
	$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $res_2['title']);
	$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $res_2['id'];
	
	$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $res_2['id'];	
}else{
	header('Location: '.URL.'home/');
}
?>

<!-- Start-->
<div id="content_holder">
<!-- Start-->
<div class="content_center content_center1">
<div class="fixbox1">
<div class="breadcrumb1"><?php echo get_crumbs($res_2['category_id'], "0", $res_2['category_id']); ?> / <a href="<?php echo $lnk; ?>"><?php echo $res_2['title']; ?></a></div>
<div class="headbox">
<?php if($res_2['icon']!=''){ ?>
<div class="im1" style="background-image:url(<?php echo URL . 'uploads/icons/thumbs/'. $res_2['icon']; ?>);"></div>
<?php } ?>
<h3><?php echo $res_2['title']; ?></h3>
</div>
<div class="reviewbox2">
<div class="reviews1">
<h1><strong>USER REVIEWS</strong></h1>
</div>
</div>

<div class="mainbox">
<div class="box4">
<div class="tobox1">
<div class="singletotal">
<p class="rew1"><?php echo $res_1['review_title']; ?></p>
<p><?php echo nl2br($res_1['review']); ?></p>
</div>
<div class="total2"></div>
<div class="tabox1" style="margin-right:40px;">Reviewed by <?php echo $sres_3['name'] .' - '. $res_1['date_reviewed']; ?></div>
</div>
</div>
<div class="abox">
<a href="<?php echo $lnk; ?>/"><img src="images/back_arrow.png" width="11" height="10" style="margin-right:5px;" />Back to <?php echo $res_2['title']; ?></a></div>
<div class="abox" style="float:right;">
<a href="<?php echo $lnk1; ?>/"><img src="images/back_arrow.png" width="11" height="10" style="margin-right:5px;" />Back to User Reviews</a>
</div>
</div>

</div></div></div>
<!-- End-->

<?php require('includes/footer.php'); ?>