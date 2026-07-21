<?php
define('TITLE','Download Software');
require('includes/header.php');

$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
//echo $id.'hi';
$sql2 = mysql_query("select * from `softwares` where `id`='$id'");
if(mysql_num_rows($sql2)>0){
	$res2 = mysql_fetch_array($sql2);
	
	$d_cnt = $res2['download_count']+1;
	$cnt_query = mysql_query("update `softwares` set `download_count`='$d_cnt' where `id`='$res2[id]'");

	$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $res2['title']);
	$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $res2['id'];
	//print_r($res2);
}else{
	header('Location: '.URL.'home/');
}
?>

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">

<div class="fixbox">
<div class="breadcrumb"><?php echo get_crumbs($res2['category_id'], "0", $res2['category_id']); ?> / <a href="<?php echo $lnk.'/'; ?>"><?php echo $res2['title']; ?></a> / <a href="javascript:void(0);">Download</a></div>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1><?php echo $res2['title']; ?> - Downloading...</h1>
</div>
<div class="box2">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs">
<li><a href="javascript:void(0);" rel="software1" class="selected">Download</a></li>
</ul>

<div id="software1" class="tabcontent">

<div class="download">
<span>Thank you for downloading this software...</span>
<a href="<?php echo $res2['download_link']; ?>" target="_blank">Click here to download</a>
</div>
 
</div></div>

</div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<link href="<?php echo URL; ?>css/core.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL; ?>js/core.js"></script>
<?php require('includes/footer.php'); ?>