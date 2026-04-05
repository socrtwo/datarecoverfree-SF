<?php
	require('includes/configure.php');
	require_once('classes/Helper.php');	
	$key = isset($_POST['key'])?$_POST['key']:'';
	
	if($key == 'newsoft'){
		//echo 'success';
		if(isset($_POST['lastmsg']) &&is_numeric($_POST['lastmsg']))
		{
			$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
			$lastmsg=$_POST['lastmsg'];
			$new1 = mysql_query("select * from `softwares` where `id`<'$lastmsg' and `category_id`='$cat_id' order by id desc limit 5");
			while($new = mysql_fetch_array($new1)){
				$n_msg_id = $new['id'];
				$class = Helper::id2Name($new['rating']);	
				$class = !empty($class) ? ' '.$class : null;
				$review1 = mysql_query("select * from `review` where `sid`='$new[id]' and `status`='1'");
				$review = mysql_num_rows($review1);
			?>
				<div class="totaldiv">
				<a href="#"><?php echo $new['title']; ?></a>
				<h2>
				<a href="#" class="down"></a>
				<a href="#" class="review"><?php echo $review; ?></a>
				</h2>
				<p><?php echo $new['tag']; ?></p>
				<div class="stars<?php echo $class; ?>" id="item_<?php echo $new['id']; ?>"></div>
				</div>				
<?php                
			}
			if(mysql_num_rows($new1)==5){
?>
                <div class="more" id="n_style">
                <a href="#" id="<?php echo $n_msg_id; ?>" class="nmore"><img src="<?php echo URL; ?>images/more.png" class="m" width="68" height="15" /></a>
                </div>
<?php				
			}
		}
	}
?>