<?php
	require('includes/common.php');
	
	$del_id = isset($_REQUEST['del_id'])?$_REQUEST['del_id']:'';
	$stat_id = isset($_REQUEST['stat_id'])?$_REQUEST['stat_id']:'';	
	
	if($del_id){
		$del_sql = mysql_query("delete from users where id='$del_id'");
		if($del_sql == 'true'){
			$del_sql1 = mysql_query("delete from uploads where `userid`='$del_id'");
			header('Location: main.php?info=User Deleted Successfully');
		}else
			header('Location: main.php?info=Error in Deleting. Please try again later');
	}
	
	if($stat_id){
		$stat = isset($_REQUEST['stat'])?$_REQUEST['stat']:'';
		if($stat=='enable')
			$stat_sql = mysql_query("update users set block='1' where id='$stat_id'");
		else
			$stat_sql = mysql_query("update users set block='0' where id='$stat_id'");
		if($stat_sql == 'true')
			header('Location: main.php?info=User Updated Successfully');
		else
			header('Location: main.php?info=Error in Updation. Please try again later');
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Users Page</title>
<link href="favicon.ico" rel="shortcut icon" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF">
<?php require('includes/header.php'); ?>
<?php if(isset($_GET['info'])) { ?>
<div class="infor"><?php echo $_GET['info']; ?></div>
<?php } ?>
<?php	/*
		Place code to connect to your DB here.
	*/
	//include('config.php');	// include your code to connect to DB.

	$tbl_name="users";		//your table name
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
	$targetpage = "main.php"; 	//your file name  (the name of this file)
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
	} ?>
<div id="admintablewrapper">
  <table width="100%" bgcolor="#FFFFFF" cellpadding="3" cellspacing="3" border="0" style="font:'trebuchet MS'; font-size:12px; margin:0px;">
    <tr style=" color:#FFFFFF; background-color:#5c5c5c; text-align:center; width:100%;">
      <td style="width:5%;">Id</td>
      <td style="width:15%;">Name</td>
      <td style="width:20%;">Email</td>
      <td style="width:15%;">Phone</td>
      <td style="width:25%;">Address</td>
      <td style="width:15%;">Actions</td>
      <td style="width:15%;">Status</td>      
    </tr>
	<?php
		while($row = mysql_fetch_array($result))
		{ ?>
	
		<tr style="text-align:center; background-color:#e4e4e4;">
    	<td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo nl2br($row['address']); ?></td>
        <td class="actions"><a href="viewdetails.php?id=<?php echo $row['id']; ?>">View Details</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="main.php?del_id=<?php echo $row['id']; ?>">Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if($row['block']=='1'){ ?>
        <a href="main.php?stat_id=<?php echo $row['id']; ?>&stat=disable">Disable</a></td>
        <?php } else { ?>
        <a href="main.php?stat_id=<?php echo $row['id']; ?>&stat=enable">Enable</a></td>
        <?php } ?>        
        <td>
        <?php if($row['block']=='1'){ ?>
        <img src="images/enable.png" />
        <?php } else { ?>
        <img src="images/disable.png" />
        <?php } ?>
        </td>
	    </tr>

<?php	}	?>
  </table>
  </form>
</div>
<?php echo $pagination; ?>
</body>
</html>
