<?php
define('TITLE','Forgot Password');
require('includes/header.php'); 
?>

<!-- Start-->
<div id="content_holder">
<?php require('includes/leftcontent.php'); ?>
<!-- Start-->
<div class="content_center">
<?php require('includes/fixbanner.php'); ?>
<div class="reviewbox1">
<div class="reviews">
<h1>Forgot Your Password</h1>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#forgotp').ajaxForm({
			target: '#ferror',
			success: function() {
				$('#ferror').fadeIn('slow');
			}
		});
	});
</script>

<div class="subbox1">
<div class="forgotp">
<div id="ferror"></div>
<form action="<?php echo URL; ?>forgot_function.php" name="forgotp" id="forgotp" method="post">
<label for="femail">Email Address</label>
<input type="text" name="femail" id="femail" value="" />
<input type="submit" value="Submit" />
</form>
</div></div>



</div></div>
<?php require('includes/rightcontent.php'); ?>
<!-- End-->
</div>
<!-- End-->

<?php require('includes/footer.php'); ?>