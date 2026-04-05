<?php
define('TITLE','Welcome to');
require_once('classes/Helper.php');
require('includes/header.php'); 

$hot1 = mysql_query("select * from `softwares` order by `votes` desc limit 0,5");
$new1 = mysql_query("select * from `softwares` order by `id` desc limit 0,5");
$top1 = mysql_query("select * from `softwares` order by `download_count` desc limit 0,5");
?>

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">
<?php require('includes/fixbanner.php'); ?>
<div class="reviewbox1">
<div class="reviews">
<h1>Latest software reviews</h1>
</div>
<div class="box2">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs">
<li><a href="javascript:void(0);" rel="software1" class="selected">Hot Software</a></li>
<li><a href="javascript:void(0);" rel="software2">New Software</a></li>
<li><a href="javascript:void(0);" rel="software3">Top Downloads</a></li>
</ul>

<div id="software1" class="tabcontent">

<?php
if(mysql_num_rows($hot1)>0){
	while($hot = mysql_fetch_array($hot1)){
		$class = Helper::id2Name($hot['rating']);	
		$class = !empty($class) ? ' '.$class : null;
		$review1 = mysql_query("select * from `review` where `sid`='$hot[id]' and `status`='1'");
		$review = mysql_num_rows($review1);
		
		$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $hot['title']);
		$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $hot['id'];
		$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $hot['id'];
		$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $hot['id'];		
		//echo $lnk;
?>
<div class="totaldiv">
<a href="<?php echo $lnk; ?>/"><?php echo $hot['title']; ?></a>
<h2>
<a href="<?php echo $lnk2; ?>/" class="down"></a>
<?php if($review>0){ ?>
<a href="<?php echo $lnk1; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($hot['tag']>0){ ?>
<p><?php echo $hot['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $hot['id']; ?>"></div>
</div>
<?php } ?>

<div class="more">
<a href="<?php echo URL; ?>hot-software-all/" class="more"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>

<?php }else{ ?>
	<div class="nosoftwares">Currently no softwares present in this section</div>	
<?php } ?>

</div>

<div id="software2" class="tabcontent">

<?php
if(mysql_num_rows($new1)>0){
	while($new = mysql_fetch_array($new1)){
		$class = Helper::id2Name($new['rating']);	
		$class = !empty($class) ? ' '.$class : null;
		$review1 = mysql_query("select * from `review` where `sid`='$new[id]' and `status`='1'");
		$review = mysql_num_rows($review1);
		
		$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $new['title']);
		$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $new['id'];
		$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $new['id'];		
		$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $new['id'];				
?>
<div class="totaldiv">
<a href="<?php echo $lnk; ?>"><?php echo $new['title']; ?></a>
<h2>
<a href="<?php echo $lnk2; ?>/" class="down"></a>
<?php if($review>0){ ?>
<a href="<?php echo $lnk1; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($new['tag']>0){ ?>
<p><?php echo $new['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $new['id']; ?>"></div>
</div>
<?php } ?>

<div class="more">
<a href="<?php echo URL; ?>new-software-all/" class="more"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>

<?php }else{ ?>
	<div class="nosoftwares">Currently no softwares present in this section</div>	
<?php } ?>

</div>

<div id="software3" class="tabcontent">

<?php
if(mysql_num_rows($top1)>0){
	while($top = mysql_fetch_array($top1)){
		$class = Helper::id2Name($top['rating']);	
		$class = !empty($class) ? ' '.$class : null;
		$review1 = mysql_query("select * from `review` where `sid`='$top[id]' and `status`='1'");
		$review = mysql_num_rows($review1);
		
		$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $top['title']);
		$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $top['id'];		
		$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $top['id'];				
		$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $top['id'];				
?>
<div class="totaldiv">
<a href="<?php echo $lnk; ?>/"><?php echo $top['title']; ?></a>
<h2>
<a href="<?php echo $lnk2; ?>/" class="down"></a>
<?php if($review>0){ ?>
<a href="<?php echo $lnk1; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($top['tag']>0){ ?>
	<p><?php echo $top['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $top['id']; ?>"></div>
</div>
<?php } ?>

<div class="more">
<a href="<?php echo URL; ?>top-downloads-all/" class="more"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>

<?php }else{ ?>
	<div class="nosoftwares">Currently no softwares present in this section</div>	
<?php } ?>

</div>


</div></div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<link href="<?php echo URL; ?>css/core.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL; ?>js/core.js"></script>
<?php require('includes/footer.php'); ?>