<?php
define('TITLE','Sub Category');
require('includes/header.php');
require_once('classes/Helper.php');

$id = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):'';
//echo $id.'hi';

$sql1 = mysql_query("select * from `categories` where `id`='$id'");
if(mysql_num_rows($sql1)>0){
	$res1 = mysql_fetch_array($sql1);
	$cat_id = $res1['id'];
	$has_subcategories = false;
	
	$sql2 = mysql_query("select * from `categories` where `id`='$res1[parentid]'");
	if(mysql_num_rows($sql2)>0){
		$res2 = mysql_fetch_array($sql2);
	}

	$count1 = mysql_query("select count(*) as count from `softwares` where `category_id`='$res1[id]'");
	$count_val = mysql_fetch_assoc($count1);
	$count = $count_val['count'];

	$hot1 = mysql_query("select * from `softwares` where `category_id`='$res1[id]' order by `votes` desc limit 0,5");
	$top1 = mysql_query("select * from `softwares` where `category_id`='$res1[id]' order by `download_count` desc limit 0,5");
}else{
	header('Location: '.URL.'home/');
}
?>

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent_all.php'); ?>
<!-- Start-->
<div class="content_center">

<div class="fixbox">
<div class="breadcrumb">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="<?php echo URL.'category/' . strtolower(str_replace(' ','-',$res2['name'])) . '/' . $res2['id']; ?>"><?php echo $res2['name']; ?></a> / <a href="javascript:void(0);"><?php echo $res1['name']; ?></a></div>
<h2><font color="#32507d"><strong><?php echo $res1['name']; ?></strong></font> (<?php echo $count; ?> programs)</h2>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1><?php echo $res1['name']; ?></h1>
</div>
<div class="box2">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs">
<li><a href="javascript:void(0);" rel="software2" class="selected">New Software</a></li>
<li><a href="javascript:void(0);" rel="software1">Hot Software</a></li>
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
?>
<div class="totaldiv">
<a href="<?php echo $lnk; ?>/"><?php echo $hot['title']; ?></a>
<h2>
<a href="<?php echo $lnk2; ?>/" class="down"></a>
<?php if($review>0){ ?>
	<a href="<?php echo $lnk; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($hot['tag']>0){ ?>
	<p><?php echo $hot['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $hot['id']; ?>"></div>
</div>
<?php } ?>

<?php if($count > 5){ ?>
<div class="more">
<a href="<?php echo URL; ?>hot-software/<?php echo $res1['id']; ?>/" class="more"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>
<?php } ?>

<?php }else{ ?>
	<div class="nosoftwares">Currently no softwares present in this section</div>	
<?php } ?>

</div>

<div id="software2" class="tabcontent">

<?php
$new1 = mysql_query("select * from `softwares` where `category_id`='$res1[id]' order by `id` desc limit 5");
if(mysql_num_rows($new1)>0){
	while($new = mysql_fetch_array($new1)){
		$n_msg_id = $new['id'];
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
<a href="<?php echo $lnk; ?>/"><?php echo $new['title']; ?></a>
<h2>
<a href="<?php echo $lnk2; ?>/" class="down"></a>
<?php if($review>0){ ?>
	<a href="<?php echo $lnk; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($new['tag']>0){ ?>
	<p><?php echo $new['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $new['id']; ?>"></div>
</div>
<?php } ?>

<?php if($count > 5){ ?>
<div class="more" id="n_style">
<a href="#" id="<?php echo $n_msg_id; ?>" class="nmore"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>
<?php } ?>

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
	<a href="<?php echo $lnk; ?>/" class="review"><?php echo $review; ?></a>
<?php } ?>
</h2>
<?php if($top['tag']>0){ ?>
	<p><?php echo $top['tag']; ?></p>
<?php } ?>
<div class="stars<?php echo $class; ?>" id="item_<?php echo $top['id']; ?>"></div>
</div>
<?php } ?>

<?php if($count > 5){ ?>
<div class="more">
<a href="<?php echo URL; ?>top-downloads/<?php echo $res1['id']; ?>/" class="more"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
</div>
<?php } ?>

<?php }else{ ?>
	<div class="nosoftwares">Currently no softwares present in this section</div>	
<?php } ?>

</div>

</div></div>

</div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<link href="<?php echo URL; ?>css/core.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL; ?>js/core.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.nmore').live("click",function() {
	  var last_msg_id = $(this).attr("id");
	  
	  if(last_msg_id!='end'){
		  $.ajax({
			  type: "POST",
			  url: "<?php echo URL; ?>controller.php",
			  data: "key=newsoft&lastmsg="+ last_msg_id +"&cat_id="+ <?php echo $cat_id; ?>,
			  beforeSend:  function() {
				  $('a.nmore').append('<br /><br /><img src="<?php echo URL; ?>images/loader.gif" />');
			  },
			  success: function(html){
				  $("#n_style").remove();
				  $("div#software2").append(html);
			  }
		  });
	  }
	  
	  return false;
	});
});
</script>
<?php require('includes/footer.php'); ?>