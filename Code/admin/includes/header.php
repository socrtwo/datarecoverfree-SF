<?php ob_start(); require('includes/common.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo TITLE; ?></title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jqueryslidemenu.css" />

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jqueryslidemenu.js"></script>

<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

</head>
<body>
<div class="adminheaderarea">
  <div class="adminlogo"> <a href="index.php" class="logo"><img src="images/logo_03.png" alt="S2 Services" border="0" /></a>
  <?php if(isset($_SESSION['admin_id_Sq'])){ ?>
  <div class="usertxt"><input type="button" value=" " onclick="javascript: location.href='logout.php';" /></div>
  <?php } ?>
</div>

<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a href="main.php">Home</a></li>
<li><a href="javascript:void(0);">Add</a>
  <ul>
  <li><a href="addcategory.php">Category</a></li>
  <li><a href="addsoftware.php">Software</a></li>
  <li><a href="addos.php">Operating System</a></li>  
  <li><a href="addlinks.php">Custom Links</a></li>    
  </ul>
</li>
<li><a href="javascript:void(0);">View</a>
  <ul>
  <li><a href="categories.php">Category</a></li>
  <li><a href="softwares.php">Software</a></li>
  <li><a href="os.php">Operating System</a></li>    
  <li><a href="links.php">Custom Links</a></li>
  <li><a href="newsletter.php">Newsletter</a></li>
  <li><a href="users.php">Registered Users</a></li>
  <li><a href="review.php">User Reviews</a></li>    
  </ul>
</li>
<li><a href="javascript:void(0);">Tools</a>
  <ul>
  <li><a href="newsletter_excel.php">Export Newsletter Data to Excel</a></li>
  </ul>
</li>
<li><a href="editpassword.php">Edit Password</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
</div>
<?php if(isset($_GET['info'])) { ?>
<div class="infor"><?php echo $_GET['info']; ?></div>
<?php } ?>