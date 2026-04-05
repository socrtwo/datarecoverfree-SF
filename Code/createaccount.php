<?php require_once('includes/configure.php'); ?>
<style type="text/css">
.login {
	margin:0px;
	padding:0px;
	float:left;
	display:inline;
	width:370px;
	height:auto;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
}
.login fieldset {
	border:1px solid #4971a5;
	background-color:#dbedff;
}
.login legend {
	background-color:#4971a5;
	padding:10px;
	border-radius: 5px 5px 5px 5px;
    color: #FFFFFF;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: bold;	
}
.login p{
	margin:15px 0 0 0;
	padding:0px;
	float:left;
	display:inline;
	width:100%;
}
.login p b{
	margin:0px;
	padding:0px;
	float:left;
	display:inline;
	width:15px;
}
.login p label{
	margin:0px 0 0 23px;
	padding:0px;
	float:left;
	display:inline;
	width:105px;
}
.login p .inp{
	width:180px;
	border:1px solid #4971a5;
	padding:3px 0px;
}
.login p #resend_password_link{
	margin:0px 0px 0px 130px;
	padding:0px;
	float:left;
	display:inline;
	color:#32507D;
	text-decoration:none;
}
.login p #signin_submit{
	margin:0px 0px 0px 190px;
	padding:0px;
	float:left;
	display:inline;
    background: url("<?php echo URL; ?>images/bg-btn-blue1.png") repeat-x scroll 0 0 #3399DD;
    border: 1px solid #32507D;
    border-radius: 4px 4px 4px 4px;
    color: #FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
    font-size: 11px;
    font-weight: bold;
    padding: 4px 10px 5px;
	cursor:pointer;
}
.login #rerror{
	margin:5px 0px 0px 25px;
	padding:0px;
	float:left;
	display:none;
	color:#F00;
}
.login #rerror span{
	color:#090;
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$('#caccount').ajaxForm({
			target: '#rerror',
			success: function() {
				$('#rerror').fadeIn('slow');
			}
		});
	});
</script>
<div class="login">
  <fieldset>
    <legend>Enter your details to register now</legend>
    <div id="rerror">All the fields are required</div>
    <form action="<?php echo URL; ?>account_function.php" id="caccount" method="post">
      <p><label for="rname">Full Name</label><b>:</b><input type="text" value="" name="rname" id="rname" class="inp" /></p>    
      <p><label for="remail">Email Address</label><b>:</b><input type="text" value="" name="remail" id="remail" class="inp" /></p>
      <p><label for="rpassword">Password</label><b>:</b><input type="password" value="" name="rpassword" id="rpassword" class="inp" /></p>
      <p><label for="rcpassword">Confirm Password</label><b>:</b><input type="password" value="" name="rcpassword" id="rcpassword" class="inp" /></p>
      <p class="remember"><input type="submit" value="Register" id="signin_submit" /></p>
    </form>
  </fieldset>
</div>