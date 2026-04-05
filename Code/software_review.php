<?php
define('TITLE','Software Review Page');
require('includes/header.php'); 

$emptt = true;

$id = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):'';
//echo $id;
$sql_1 = mysql_query("select * from `review` where `sid`='$id' and `status`='1'");
if(mysql_num_rows($sql_1)>0){
	$emptt = false;
}else{
	//header('Location: '.URL.'home/');
	$emptt = true;
}

$sql_2 = mysql_query("select * from `softwares` where `id`='$id'");
$res_2 = mysql_fetch_array($sql_2);
	
$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $res_2['title']);
$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $res_2['id'];
?>

<?php if($emptt === false){ ?>
<script type="text/javascript">
  $(document).ready(function(){
	  function loading_show(){
		  $('#srloading').html("<img src='<?php echo URL; ?>images/loading.gif'/>").fadeIn('fast');
	  }
	  function loading_hide(){
		  $('#srloading').fadeOut('fast');
	  }                
	  function loadData(page){
		  loading_show();                    
		  $.ajax
		  ({
			  type: "POST",
			  url: "<?php echo URL; ?>load_data.php",
			  data: "key=sreview&sid="+<?php echo $res_2['id']; ?>+"&page="+page,
			  success: function(msg)
			  {
				  $("#srcontainer").ajaxComplete(function(event, request, settings)
				  {
					  loading_hide();
					  $("#srcontainer").html(msg);
				  });
			  }
		  });
	  }
	  loadData(1);  // For first time page load default results
	  $('#srcontainer .srpagination li.active').live('click',function(){
		  var page = $(this).attr('p');
		  loadData(page);
		  
	  });           
  });
</script>
<?php } ?>

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

<?php if($emptt === false){ ?>
<div id="srloading"></div>
<div id="srcontainer">
     <div class="srdata"></div>
     <div class="srpagination"></div>
</div>
<?php }else{ ?>
<div class="info11">Currently there are no reviews for this software. Be first to <a href="<?php echo URL; ?>software.php?id=<?php echo $id; ?>&softwaretabs=3">write a review</a></div>
<?php } ?> 
</div>
</div>

</div>
</div>
</div>

<!-- End-->

<?php require('includes/footer.php'); ?>