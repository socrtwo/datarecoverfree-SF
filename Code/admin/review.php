<?php define('TITLE','Review Page'); require('includes/header.php'); ?>
<?php
	$del_id = isset($_REQUEST['del_id'])?mysql_real_escape_string($_REQUEST['del_id']):'';
	$update_id = isset($_REQUEST['update_id'])?mysql_real_escape_string($_REQUEST['update_id']):'';
	
	if($del_id){
		$del_sql = mysql_query("delete from review where id='$del_id'");
		if($del_sql == 'true'){
			header('Location: review.php?info=Review Deleted Successfully');
		}else
			header('Location: review.php?info=Error in Deleting. Please try again later');
	}
	
	if($update_id){
		$update_sql = mysql_query("select * from `review` where `id`='$update_id'");
		if(mysql_num_rows($update_sql)>0){
			$update_res = mysql_fetch_array($update_sql);
			if($update_res['status']=='1'){
				$update_sql1 = "update `review` set `status`='0' where `id`='$update_id'";
			}else{
				$update_sql1 = "update `review` set `status`='1' where `id`='$update_id'";				
			}
			$update_res1 = mysql_query($update_sql1);
			if($update_res1){
				header('Location: review.php?info=Status Updated Successfully');
			}else{
				header('Location: review.php?info=Error in updation. Try again later');
			}
		}
	}
?>
<div id="admincontentarea">
<?php	/*
		Place code to connect to your DB here.
	*/
	//include('config.php');	// include your code to connect to DB.

	$tbl_name="review";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "review.php"; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	$page = isset($_GET['page'])?$_GET['page']:'0';
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name order by id desc LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	//echo $lastpage;
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">« previous</a>";
		else
			$pagination.= "<span class=\"disabled\">« previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next »</a>";
		else
			$pagination.= "<span class=\"disabled\">next »</span>";
		$pagination.= "</div>\n";		
	} if(mysql_num_rows($result)>0){ ?>
<div id="admintablewrapper">
  <table width="100%" bgcolor="#FFFFFF" cellpadding="3" cellspacing="3" border="0" style="font:'trebuchet MS'; font-size:12px; margin:0px;">
    <tr style=" color:#FFFFFF; background-color:#40679e; text-align:center; width:100%;">
      <td style="width:5%;">Id</td>
      <td style="width:10%;">Software</td>
      <td style="width:10%;">User</td>      
      <td style="width:20%;">Review Title</td>      
      <td style="width:30%;">Review</td>                  
      <td style="width:10%;">Status</td>                        
      <td style="width:15%;">Actions</td>
    </tr>
	<?php
		while($row = mysql_fetch_array($result))
		{ 
			$sql1 = mysql_query("select `title` from `softwares` where `id`='$row[sid]'");
			$row1 = mysql_fetch_array($sql1);

			$sql2 = mysql_query("select `name` from `users` where `id`='$row[uid]'");
			$row2 = mysql_fetch_array($sql2);
	?>
	
		<tr style="text-align:center; background-color:#e4e4e4;">
    	<td><?php echo $row['id']; ?></td>
        <td><?php echo $row1['title']; ?></td>
        <td><?php echo $row2['name']; ?></td>        
        <td><?php echo $row['review_title']; ?></td>        
        <td align="left"><?php echo nl2br($row['review']); ?></td>
        <td><?php if($row['status']=='1'){ ?><img src="images/tick.png" width="32" height="32" /><?php }else{ ?><img src="images/wrong.png" width="32" height="32" /><?php } ?></td>        
        <td class="actions"><a href="review.php?update_id=<?php echo $row['id']; ?>">Update Status</a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onClick='var answer = confirm("Are you sure want to delete this?"); if (answer){ window.location = "review.php?del_id=<?php echo $row['id']; ?>"; }'>Delete</a></td>
	    </tr>

<?php	}	?>
  </table>
</div>
<?php echo $pagination; }else{ ?>
<div id="admintablewrapper"><p style="text-align:center;">No Records</p></div>
<?php } ?>
</div>
<?php require('includes/footer.php'); ?>