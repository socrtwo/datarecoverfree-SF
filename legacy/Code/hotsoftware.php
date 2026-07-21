<?php
define('TITLE','Hot Software');
require('includes/header.php');

$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
//echo $id.'hi';
$sql2 = mysql_query("select * from `categories` where `id`='$id'");
if(mysql_num_rows($sql2)>0){
	$res2 = mysql_fetch_array($sql2);
	//print_r($res2);
}else{
	header('Location: '.URL.'home/');
}
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
			  data: "key=hotsoftware&catid="+<?php echo $res2['id']; ?>+"&page="+page,
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

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">

<div class="fixbox">
<div class="breadcrumb">You are here :  <a href="<?php echo URL; ?>home/">Home</a> / <a href="<?php echo URL.'sub-category/'.strtolower(str_replace(' ','-',$res2['name'])).'/'.$res2['id'].'/'; ?>"><?php echo $res2['name']; ?></a> / <a href="javascript:void(0);">Hot Softwares</a></div>
</div>

<div class="reviewbox1">
<div class="reviews">
<h1><?php echo $res2['name']; ?> - Hot Softwares</h1>
</div>
<div class="box2">
<!-- Start-->
<ul id="softwaretabs" class="shadetabs">
<li><a href="javascript:void(0);" rel="software1" class="selected">Hot Software</a></li>
</ul>

<div id="software1" class="tabcontent">

 <div id="hloading"></div>
 <div id="hcontainer">
     <div class="hdata"></div>
     <div class="hpagination"></div>
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