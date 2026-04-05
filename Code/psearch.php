<?php
define('TITLE','Popular Search');
require('includes/header.php');

$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
$oid = str_replace('=',']',$id);
//echo $oid; exit;
$id = str_replace('=',',',str_replace('-',' ',$id));
//echo "select * from `softwares` where `os` LIKE '%$id%'"; exit;
$sql2 = mysql_query("select * from `softwares` where `os` LIKE '%$id%'");
if(mysql_num_rows($sql2)>0){
	$res2 = mysql_fetch_array($sql2);
	//print_r($res2);
	$sql3 = mysql_query("select * from `softwares` where `os` LIKE '%$id%'");
}else{
	header('Location: '.URL.'home/');
}

if(mysql_num_rows($sql3)>0){
?>
<script type="text/javascript">
  $(document).ready(function(){
	  function loading_show(){
		  $('#hloading').html("<img src='<?php echo URL; ?>images/loading.gif'/>").fadeIn('fast');
	  }
	  function loading_hide(){
		  $('#hloading').fadeOut('fast');
	  }                
	  function loadData(page){
		  loading_show();                    
		  $.ajax
		  ({
			  type: "POST",
			  url: "<?php echo URL; ?>load_data.php",
			  data: "key=psearch&id=<?php echo $id; ?>&page="+page,
			  success: function(msg)
			  {
				  $("#hcontainer").ajaxComplete(function(event, request, settings)
				  {
					  loading_hide();
					  $("#hcontainer").html(msg);
				  });
			  }
		  });
	  }
	  loadData(1);  // For first time page load default results
	  $('#hcontainer .hpagination li.active').live('click',function(){
		  var page = $(this).attr('p');
		  loadData(page);
		  
	  });           
  });
</script>
<?php } ?>
<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">

<div class="fixbox">
<div class="breadcrumb">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="javascript:void(0);">Popular Searches</a></div>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1><?php echo strtoupper($id); ?> - Popular Searches</h1>
</div>
<div class="box2">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs">
<li><a href="javascript:void(0);" rel="software1" class="selected">Popular Searches</a></li>
</ul>

<div id="software1" class="tabcontent">

<?php if(mysql_num_rows($sql3)>0){ ?>
 <div id="hloading"></div>
 <div id="hcontainer">
     <div class="hdata"></div>
     <div class="hpagination"></div>
 </div>
 <?php }else{ ?>
 	<div class="nosoftwares">Currently no softwares present in this section</div>
 <?php } ?>

</div></div>

</div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<link href="<?php echo URL; ?>css/core.css" rel="stylesheet" type="text/css" />
<script src="<?php echo URL; ?>js/core.js"></script>
<?php require('includes/footer.php'); ?>