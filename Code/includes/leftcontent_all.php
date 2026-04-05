<!-- Start-->
<div class="content_left">
<!-- Start-->
<div class="category">
<div class="categorybox">
<h1><a href="<?php echo URL; ?>categories/">Categories</a></h1>
</div>
<div class="suckerdiv box1">
<ul>

<?php
$llid = isset($_REQUEST['id'])?mysql_real_escape_string($_REQUEST['id']):''; 
$sql2 = mysql_query("select * from `categories` where `parentid`='$res2[id]' and `id`!='$llid' order by id desc limit 0,5");
if(mysql_num_rows($sql2)>0){
	while($vaa = mysql_fetch_array($sql2)){
?>
<li><a href="<?php echo URL.'sub-category/' . strtolower(str_replace(' ','-',$vaa['name'])) . '/' . $vaa['id'] . '/'; ?>"><?php echo $vaa['name']; ?></a></li>
<?php } } ?>

</ul>
</div>
<div class="drop"><a href="<?php echo URL; ?>categories/" class="d1">All Categories <font color="#32507d"><strong>+</strong></font></a></div>
</div>
<!-- End-->
<!-- Start-->
<div class="category" style="margin-top:12px;">
<div class="categorybox">
<h1>Popular Searches</h1>
</div>
<div class="box1">
<?php generate_os_menu(); ?>
</div>
</div>
<!-- End-->
<!-- Start-->
<div class="newsletter">
<form action="#" method="post" onsubmit="return t_validate();" id="myForm">
<input name="email" id="email" class="inp1" type="text" placeholder="Enter Your Email Here" value="" />
<input class="submit" type="submit" value="" /><img src="<?php echo URL; ?>images/loader.gif" alt="Loader" id="indi_1" />
</form>
<script type="text/javascript">
function t_validate(){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var theemail = document.getElementById('email').value;
	if (reg.test(theemail) == false){ //crude check for invalid email
		jQuery.facebox('Enter a Valid Email Address');
		return false //cancel closing of modal window
	}
	else {
	var dataString = 'email='+ theemail +'&action=subm';

	$.ajax({
	   type: "POST",
	   url: "<?php echo URL.'newsletter_db.php'; ?>",
	   data: dataString,
	   cache: false,
	   beforeSend: function()
	   {
	   $("#myform").css('display','none');
	   $("#indi_1").css('display','inline');
	   }, 
	   success: function(msg)
	   {
	   $("#indi_1").css('display','none');
	   if(msg == 'success'){
   		jQuery.facebox('Thank You for Subscription');
		$("#email").val(' ');
		$("#myform").css('display','inline');
	   }else{
		jQuery.facebox(msg);
		$("#myform").css('display','inline');
	   }
	  }
	});
	return false;
  }
}
</script>
</div>
<!-- End-->
<div class="advertise">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-9590646740012169";
/* new-s2-services */
google_ad_slot = "6475406262";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</div>
<!-- End-->