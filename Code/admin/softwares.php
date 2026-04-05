<?php define('TITLE','Softwares Page'); require('includes/header.php'); ?>
<?php
	$del_id = isset($_REQUEST['del_id'])?mysql_real_escape_string($_REQUEST['del_id']):'';
	
	if($del_id){
		$del_sql = mysql_query("delete from softwares where id='$del_id'");
		if($del_sql == 'true'){
			header('Location: softwares.php?info=Category Deleted Successfully');
		}else
			header('Location: softwares.php?info=Error in Deleting. Please try again later');
	}
?>
<div id="admincontentarea">
<?php	/*
		Place code to connect to your DB here.
	*/
	//include('config.php');	// include your code to connect to DB.

	$tbl_name="softwares";		//your table name
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
	$targetpage = "softwares.php"; 	//your file name  (the name of this file)
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
      <td style="width:25%;">Icon / Screenshot</td>
      <td style="width:25%;">Title</td>
      <td style="width:15%;">Category</td>
      <td style="width:10%;">Date Modified</td>      
      <td style="width:20%;">Actions</td>
    </tr>
	<?php
		while($row = mysql_fetch_array($result))
		{ 
		$sql1 = mysql_query("select * from `categories` where `id`='$row[category_id]'");
		$row1 = mysql_fetch_array($sql1);
		?>
	
		<tr style="text-align:center; background-color:#e4e4e4;">
    	<td><?php echo $row['id']; ?></td>
        <?php if($row['icon']=='') { ?>
        <td><img src="../uploads/screenshots/<?php echo $row['screenshot1']; ?>" alt="<?php echo $row['title']; ?>" width="100" height="75" /></td>
        <?php }else{ ?>
        <td><img src="../uploads/icons/<?php echo $row['icon']; ?>" alt="<?php echo $row['title']; ?>" width="50" height="50" /></td>
        <?php } ?>
    	<td><?php echo $row['title']; ?></td>
    	<td><?php echo $row1['name']; ?></td>
        <td><?php echo $row['date_modified']; ?></td>
        <td class="actions"><a href="editsoftware.php?id=<?php echo $row['id']; ?>">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">View Details</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick='var answer = confirm("Are you sure want to delete this?"); if (answer){ window.location = "softwares.php?del_id=<?php echo $row['id']; ?>"; }'>Delete</a></td>
	    </tr>

<?php	}	?>
  </table>
</div>
<?php echo $pagination; }else{ ?>
<div id="admintablewrapper"><p style="text-align:center;">No Records</p></div>
<?php } ?>
</div>
<?php require('includes/footer.php'); ?>