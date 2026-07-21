<?php
define('TITLE','Software Page');
require_once('classes/Helper.php');
require('includes/header.php'); 

$id = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):'';
$sql_1 = mysql_query("select * from `softwares` where `id`='$id'");
if(mysql_num_rows($sql_1)>0){
	$sres = mysql_fetch_array($sql_1);
	$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $sres['title']);
	$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $sres['id'];
	
	//print_r($sres);
	$sql_2 = mysql_query("select * from `review` where `sid`='$sres[id]' and `status`='1' order by id desc limit 0,5");	
	$sql_22 = mysql_query("select count(*) as count from `review` where `sid`='$sres[id]' and `status`='1'");
	$num_22 = mysql_fetch_array($sql_22);
	$num_2 = $num_22['count'];
}else{
	header('Location: '.URL.'home/');
}
?>

<?php if(mysql_num_rows($sql_1)>0){ 
		$class_editor = Helper::id2Name($sres['editor_rating']);	
		$class_editor = !empty($class_editor) ? ' '.$class_editor : null;
		
		$class = Helper::id2Name($sres['rating']);	
		$class = !empty($class) ? ' '.$class : null;
?>
<!-- Start-->
<div id="content_holder">
<!-- Start-->
<div class="content_center content_center1">
<div class="fixbox1">
<div class="breadcrumb1"><?php echo get_crumbs($sres['category_id'], "0", $sres['category_id']); ?></div>
<div class="headbox">
<?php if($sres['icon']!=''){ ?>
<div class="im1" style="background-image:url(<?php echo URL . 'uploads/icons/thumbs/'. $sres['icon']; ?>);"></div>
<?php } ?>
<h3><?php echo $sres['title']; ?></h3>
</div>

<div class="box4">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs1">
<li><a href="javascript:void(0);" rel="software1" class="selected">Product Information</a></li>
<li><a href="javascript:void(0);" rel="software2">Screenshots</a></li>
<li><a href="javascript:void(0);" rel="software3"><?php if($num_2 > 0){ echo $num_2; }?> User reviews</a></li>
<li><a href="javascript:void(0);" rel="software4">Review this program</a></li>
</ul>
<div id="software1" class="tabcontent1">
<div class="totalb1">
<div class="leftb1">
<a href="<?php echo $lnk2; ?>/"><img src="<?php echo URL; ?>images/single_download.png" width="272" height="52" /></a>
<h2>
<span><span class="s2">File Size</span><span class="s1">:</span><span class="s3"><?php echo $sres['file_size']; ?></span></span>

<?php if($sres['os']!="0"){ ?>
<span><span class="s2">OS</span><span class="s1">:</span><span class="s3">
<?php 
/*$sql_4 = mysql_query("SELECT `name` FROM `os` WHERE `id`='$sres[os]'") or die(mysql_error());
$sres_4 = mysql_fetch_array($sql_4);
echo $sres_4['name'];*/
echo $sres['os']; 
?></span></span>
<?php } ?>

<!--<span><span class="s2">Last Modified Date</span><span class="s1">:</span><span class="s3"><?php #echo $sres['date_modified']; ?></span></span>-->
<?php if($sres['download_count'] > 0){ ?>
<span><span class="s2">Downloaded</span><span class="s1">:</span><span class="s3"><?php echo $sres['download_count']; ?> Times</span></span>
<?php } ?>
<span><span class="s2">Software URL</span><span class="s1">:</span><span class="s3"><a href="<?php echo $sres['software_url']; ?>" class="surl" target="_blank"><?php echo $sres['software_url']; ?></a></span></span>
</h2>
</div>
<div class="leftb2" style="background-image:url(<?php echo URL; ?>uploads/screenshots/medium/<?php echo $sres['screenshot1']; ?>);"></div>
</div>
<div class="totalb2">
<div class="leftb3">
<span>
<span class="r1">S2 Services rating</span>
<span class="r1"><div class="stars stars1<?php echo $class_editor; ?>" id="item_<?php echo $sres['id']; ?>"></div></span>
</span>
<span style="border-bottom:none;">
<span class="r1">User rating</span>
<span class="r1">
<?php if($sres['ripaddr'] != $_SERVER['REMOTE_ADDR']){ ?>
<ul class="stars stars1<?php echo $class; ?>" id="item_<?php echo $sres['id']; ?>">
    <li><a href="#" rel="star-1"> </a></li>
    <li><a href="#" rel="star-2"> </a></li>
    <li><a href="#" rel="star-3"> </a></li>
    <li><a href="#" rel="star-4"> </a></li>
    <li><a href="#" rel="star-5"> </a></li>
</ul>
<?php }else{ ?>
<div class="stars stars1<?php echo $class; ?>" id="item_<?php echo $sres['id']; ?>"></div>
<?php } ?>
</span>
<!--<span class="r2"><strong>Rated: 1.67 from 5</strong></span>-->
<span class="r2">Rating based on <span id="votes_<?php echo $sres['id']; ?>" class="vtt"><?php echo $sres['votes']; ?></span> votes</span>
</span>
</div>
</div>

<div class="totalb3">
<div class="rbox">Description</div>
<?php if(!empty($sres['tag'])){
echo '<p class="d2">"'.$sres['tag'].'"</p>';
} ?>
<p id="dess"><?php echo nl2br($sres['description']); ?></p>
</div>
<a class="m2" id="dess1" href="javascript:void(0);" onclick="dessc()"><img width="68" height="15" src="<?php echo URL; ?>images/readmore.png"></a>
<script type="text/javascript">
function dessc(){
	$("#dess1").css('display','none');
	$("#dess").css('height','auto');
}
</script>

<?php if($sres['other_requirement']!='' && $sres['other_requirement']!='0' ){ ?>
<div class="totalb3">
<div class="rbox">Other Requirements</div>
<p id="dess1"><?php echo nl2br($sres['other_requirement']); ?></p>
</div>
<a class="m2" id="dess11" href="javascript:void(0);" onclick="dessc1()"><img width="68" height="15" src="<?php echo URL; ?>images/readmore.png"></a>
<script type="text/javascript">
function dessc1(){
	$("#dess11").css('display','none');
	$("#dess1").css('height','auto');
}
</script>
<?php } ?>
</div>

<div id="software2" class="tabcontent1">
<div class="screenbox">
<?php for($i=1;$i<=5;$i++) { 
	if($sres['screenshot'.$i]!='' && $sres['screenshot'.$i]!='0'){
		echo '<div class="inner_div">';
		echo '<a href="'.URL.'uploads/screenshots/medium/'.$sres['screenshot'.$i].'" rel="facebox" style="background-image:url('.URL.'uploads/screenshots/medium/'.$sres['screenshot'.$i].');"></a>';
		echo '</div>';
	}
} ?>
</div>
</div>

<div id="software3" class="tabcontent1">

<?php
if($num_2 > 0){
while($sres_2 = mysql_fetch_array($sql_2)){
?>
<div class="mbox1">
<div class="totalb4">
<p class="re1"><a href="<?php echo URL.'review/'.$sres_2['id']; ?>/"><?php echo $sres_2['review_title']; ?></a></p>
<p><?php echo shorten($sres_2['review'], 300); ?></p>
</div>
<div class="totalb5"></div>
<?php $sql_3 = mysql_query("select `name` from `users` where `id`='$sres_2[uid]'"); $sres_3 = mysql_fetch_array($sql_3); ?>
<div class="rbox2"><img src="<?php echo URL; ?>images/user.png" width="18" height="18" class="img2" />Reviewed by <?php echo $sres_3['name']; ?> - <?php echo $sres_2['date_reviewed']; ?></div>
</div>
<?php }if($num_2 > 5){ $ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $sres['title']); $lnk = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $sres['id'] .'/'; ?> <a href="<?php echo $lnk; ?>" class="m3">Read all reviews of this program +</a> <?php } }else{ ?>
	<div class="info11">Currently there are no reviews for this software. Be first to write a review</div>
<?php } ?>
</div>

<div id="software4" class="tabcontent1">
<?php if(empty($_SESSION['s2id']) || $_SESSION['s2id']==''){ ?>
	<div class="info11">Please <a href="<?php echo URL; ?>/login.php" rel="facebox">login</a> into your account to write a review</div>
<?php }else{ ?>
<div class="screenbox">
<div class="rbox3">
<img src="images/user.png" width="18" height="18" />
<strong>Review</strong> <em> (<?php echo $sres['title']; ?>)</em>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#reviewfrm').ajaxForm({
			target: '#rerror',
			success: function() {
				$('#rerror').fadeIn('slow');
			}
		});
	});
</script>

<div class="rbox4">
    <div class="fbox2"> 
	    <div id="rerror"></div>
        <form action="<?php echo URL; ?>review_function.php" name="reviewfrm" id="reviewfrm" method="post">
        	<input type="hidden" value="<?php echo $sres['id']; ?>" name="sid" />
            <label>Review title :</label>
            <input name="rtitle" id="rtitle" type="text" class="inp1" value="" />
            <label>Your review of <?php echo $sres['title']; ?> :</label>
            <textarea name="rreview" id="rreview" class="inp2"></textarea>
            <input type="submit" class="submit" value="" />
        </form>
    </div>
</div>
</div>
<?php } ?>
</div>

</div>
<div class="box44">
<span class='st_sharethis_hcount' displayText='ShareThis'></span>
<span class='st_twitter_hcount' displayText='Tweet'></span>
<span class='st_facebook_hcount' displayText='Facebook'></span>
<span class='st_email_hcount' displayText='Email'></span>
<span class='st_plusone_hcount' displayText='Google +1'></span>
</div>
</div></div>
<!-- End-->
</div>
<!-- End-->

<?php } ?>

<link href="<?php echo URL; ?>css/core.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL; ?>js/core.js"></script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-e16f1a94-683c-9e88-5786-447264e991ba"}); </script>
<?php require('includes/footer.php'); ?>