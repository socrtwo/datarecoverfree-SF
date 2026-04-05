<?php
    ob_start();
	require_once('includes/configure.php');
	require_once('includes/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITLE; ?> - S2Services Data Recovery Freeware List</title>
<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" />
<link href="<?php echo URL; ?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/tabcontent.css" type="text/css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/facebox.css" type="text/css" rel="stylesheet" />
<script src="<?php echo URL; ?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>js/tabcontent.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>js/menu.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>js/facebox.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>js/jquery.form.js"></script>
<script src="<?php echo URL; ?>js/ajax-search-suggest.js"></script>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js">{lang: 'en-GB'}</script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function() {
    $('a[rel*=facebox]').facebox()

	$("#caccount").ajaxForm({
		target: '#rerror',		
		success: function() {
		$('#rerror').fadeIn('slow');
		}
	});
	
	$("#lsignin").ajaxForm({
		target: '#lerror',		
		success: function() {
		$('#lerror').fadeIn('slow');
		}
	});
	
})
</script>
</head>
<body>

<div id="search-overlay">
	<h2>Begin typing to search</h2>
	<div id="close">X</div>
	<form>
		<input id="hidden-search" type="text" autocomplete="off" /> <!--hidden input the user types into-->
		<input id="display-search" type="text" autocomplete="off" readonly="readonly" /> <!--mirrored input that shows the actual input value-->
	</form>
	
	<div id="results">
		<h2 class="artists">Softwares</h2>
		<ul id="artists"></ul>
	</div>
</div>

<div id="wrapper">
<div id="wrapper_holder">
<!-- Start-->
<div id="header">
<!-- Start-->
<div id="menu">
<ul>
<li><a href="<?php echo URL; ?>home/">Home</a></li>    
<li>|</li>
<li><a href="<?php echo URL; ?>categories/">Sitemap</a></li>
<li>|</li>
<li><a href="<?php echo URL; ?>help/">Help</a></li>
<li>|</li>
<li><a href="<?php echo URL; ?>about/">About</a></li>
<li>|</li>
<li><a href="http://forum.s2services.com/" target="_blank">Forum</a></li>
</ul>

<div id="login">
<?php if(empty($_SESSION['s2id'])){ ?>
<a href="<?php echo URL; ?>login.php" rel="facebox">Login</a>
<a href="javascript:void(0);">|</a>
<a href="<?php echo URL; ?>createaccount.php" rel="facebox" class="account">Create an Account</a>
<?php }else{ ?>
<a href="javascript:void(0);"><span>Welcome, <?php echo $_SESSION['s2name']; ?></span></a>
<a href="javascript:void(0);">|</a>
<a href="<?php echo URL; ?>logout.php" class="account">Logout</a>
<?php } ?>
</div>

</div>
<!-- End-->
<!-- Start-->
<div class="topheader">
<a href="<?php echo URL; ?>home/" class="logo"></a>
<div id="search">
	Search by <b>Surprise</b> &nbsp; <img src="<?php echo URL; ?>images/search_icon.png" alt="Search" />
</div>

<!--<div class="searchbox">
<form action="#" method="get">
<input name="search" type="text" class="inp" placeholder="Search Site Here..." id="inputString" onkeyup="lookup(this.value);" value="" />
<div id="suggestions"></div>
<input class="search" type="submit" value="" />
</form>
</div>-->
</div>
<!-- End-->
</div>