<?php
require_once('includes/configure.php');

$sid = mysql_real_escape_string($_POST['sid']);
$rtitle = mysql_real_escape_string($_POST['rtitle']);
$rreview = mysql_real_escape_string($_POST['rreview']);
$emailerror = '';

if(strlen($sid) < 1 || strlen($rtitle) < 1  || strlen($rreview) < 1){
	$emailerror = '<b>Error:</b> <br />';	
	
	if(empty($rtitle)){
		$emailerror .= 'Enter Review Title <br />';	
	}
	
	if(empty($rreview)){
		$emailerror .= 'Enter Your Review <br />';	
	}	
}else{
	$date_reviewed = date('d M Y');
	$sql_account = mysql_query("insert into `review` (`sid`, `uid`, `review`, `review_title`, `date_reviewed`) values ('$sid', '$_SESSION[s2id]', '$rreview', '$rtitle', '$date_reviewed')");

	if($sql_account == '1')
			$emailerror = "<script type='text/javascript'>$('#rtitle').val('');$('#rreview').val('');</script><span>Review Submitted Successfully. Waiting for admin to confirm</span>";
}
echo $emailerror;
?>