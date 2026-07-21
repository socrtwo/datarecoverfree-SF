<?php
include('includes/configure.php');
include('includes/functions.php');
require_once('classes/Helper.php');

$key = isset($_POST['key'])?$_POST['key']:'';

if($key=='hotsoftware'){
$page = isset($_POST['page'])?$_POST['page']:'';
$catid = isset($_POST['catid'])?$_POST['catid']:'';
if($page!='')
{
$cur_page = $page;
$page -= 1;
$per_page = 5;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$query_pag_data = "select * from `softwares` where `category_id`='$catid' order by `votes` desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$msg = "";
while ($row = mysql_fetch_array($result_pag_data)) {
//$htmlmsg=htmlentities($row['title']);
    //$msg .= "<li><b>" . $row['id'] . "</b> " . $htmlmsg . "</li>";
$class = Helper::id2Name($row['rating']);	
$class = !empty($class) ? ' '.$class : null;
$review1 = mysql_query("select * from `review` where `sid`='$row[id]' and `status`='1'");
$review = mysql_num_rows($review1);

$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $row['title']);
$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];

$msg .= '<div class="totaldiv">';
$msg .= '<a href="'.$lnk.'">'.$row['title'].'</a>';
$msg .= '<h2><a href="'.$lnk2.'/" class="down"></a><a href="'.$lnk1.'" class="review">'.$review.'</a>';
$msg .= '</h2><p>'. $row['tag'] .'</p><div class="stars '. $class .'" id="item_'.$row['id'].'"></div></div>';
			
}
//$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data


/* --------------------------------------------- */
$query_pag_num = "SELECT COUNT(*) AS count FROM `softwares` where `category_id`='$catid'";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='hpagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#31507e;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
//$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='htotal' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
$msg = $msg . "</ul>" . $total_string . "</div>";  // Content for pagination
echo $msg;
}
}elseif($key=='topdownloads'){
$page = isset($_POST['page'])?$_POST['page']:'';
$catid = isset($_POST['catid'])?$_POST['catid']:'';
if($page!='')
{
$cur_page = $page;
$page -= 1;
$per_page = 5;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$query_pag_data = "select * from `softwares` where `category_id`='$catid' order by `download_count` desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$msg = "";
while ($row = mysql_fetch_array($result_pag_data)) {
//$htmlmsg=htmlentities($row['title']);
    //$msg .= "<li><b>" . $row['id'] . "</b> " . $htmlmsg . "</li>";
$class = Helper::id2Name($row['rating']);	
$class = !empty($class) ? ' '.$class : null;
$review1 = mysql_query("select * from `review` where `sid`='$row[id]' and `status`='1'");
$review = mysql_num_rows($review1);

$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $row['title']);
$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];

$msg .= '<div class="totaldiv">';
$msg .= '<a href="'.$lnk.'">'.$row['title'].'</a>';
$msg .= '<h2><a href="'.$lnk2.'/" class="down"></a><a href="'.$lnk1.'" class="review">'.$review.'</a>';
$msg .= '</h2><p>'. $row['tag'] .'</p><div class="stars '. $class .'" id="item_'.$row['id'].'"></div></div>';
			
}
//$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data


/* --------------------------------------------- */
$query_pag_num = "SELECT COUNT(*) AS count FROM `softwares` where `category_id`='$catid'";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and ending values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='hpagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#31507e;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
//$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='htotal' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
$msg = $msg . "</ul>" . $total_string . "</div>";  // Content for pagination
echo $msg;

}
}elseif($key=='psearch'){
$page = isset($_POST['page'])?$_POST['page']:'';
$osid = isset($_POST['id'])?$_POST['id']:'';
//$osid = str_replace(']',',',str_replace('-',' ',$osid));
if($page!='')
{
$cur_page = $page;
$page -= 1;
$per_page = 5;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$query_pag_data = "select * from `softwares` where `os` LIKE '%$osid%' order by `id` desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$msg = "";
while ($row = mysql_fetch_array($result_pag_data)) {
//$htmlmsg=htmlentities($row['title']);
    //$msg .= "<li><b>" . $row['id'] . "</b> " . $htmlmsg . "</li>";
$class = Helper::id2Name($row['rating']);	
$class = !empty($class) ? ' '.$class : null;
$review1 = mysql_query("select * from `review` where `sid`='$row[id]' and `status`='1'");
$review = mysql_num_rows($review1);

$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $row['title']);
$lnk = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk1 = URL . 'software-review/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];
$lnk2 = URL . 'download/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $row['id'];

$msg .= '<div class="totaldiv">';
$msg .= '<a href="'.$lnk.'">'.$row['title'].'</a>';
$msg .= '<h2><a href="'.$lnk2.'/" class="down"></a>';
if($review>0){
	$msg .= '<a href="'.$lnk1.'" class="review">'.$review.'</a>';
}
$msg .= '</h2>';
if($row['tag']>0){
	$msg .= '<p>'. $row['tag'] .'</p>';
}
$msg .= '<div class="stars '. $class .'" id="item_'.$row['id'].'"></div></div>';
			
}
//$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data


/* --------------------------------------------- */
$query_pag_num = "SELECT COUNT(*) AS count FROM `softwares` where `os`='$osid'";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='hpagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#31507e;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
//$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='htotal' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
$msg = $msg . "</ul>" . $total_string . "</div>";  // Content for pagination
echo $msg; exit;
}
}if($key=='sreview'){
$page = isset($_POST['page'])?$_POST['page']:'';
$sid = isset($_POST['sid'])?$_POST['sid']:'';
if($page!='')
{
$cur_page = $page;
$page -= 1;
$per_page = 5;
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;

$query_pag_data = "select * from `review` where `sid`='$sid' and `status`='1' order by `id` desc LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
$msg = "";
while ($row = mysql_fetch_array($result_pag_data)) {

$msg .= '<div class="tobox1">';
$msg .= '<div class="total1">';
$msg .= '<p class="rew1"><a href="'.URL.'review/'.$row['id'].'/">'.$row['review_title'].'</a></p>';
$msg .= '<p>'.shorten($row['review'], 300).'</p>';
$msg .= '</div>';
$msg .= '<div class="total2"></div>';

$sql_3 = mysql_query("select `name` from `users` where `id`='$row[uid]'"); $sres_3 = mysql_fetch_array($sql_3);

$msg .= '<div class="tabox1">Reviewed by '.$sres_3['name'] .' - '. $row['date_reviewed'] .'</div>';
$msg .= '</div>';

}
//$msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
$msg = "<div class='data'>" . $msg . "</div>"; // Content for Data


/* --------------------------------------------- */
$query_pag_num = "SELECT COUNT(*) AS count FROM `review` where `sid`='$sid' and `status`='1'";
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
/* ----------------------------------------------------------------------------------------------------------- */
$msg .= "<div class='srpagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
if ($first_btn && $cur_page > 1) {
    $msg .= "<li p='1' class='active'>First</li>";
} else if ($first_btn) {
    $msg .= "<li p='1' class='inactive'>First</li>";
}

// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
    $msg .= "<li p='$pre' class='active'>Previous</li>";
} else if ($previous_btn) {
    $msg .= "<li class='inactive'>Previous</li>";
}
for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        $msg .= "<li p='$i' style='color:#fff;background-color:#31507e;' class='active'>{$i}</li>";
    else
        $msg .= "<li p='$i' class='active'>{$i}</li>";
}

// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    $msg .= "<li p='$nex' class='active'>Next</li>";
} else if ($next_btn) {
    $msg .= "<li class='inactive'>Next</li>";
}

// TO ENABLE THE END BUTTON
if ($last_btn && $cur_page < $no_of_paginations) {
    $msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
} else if ($last_btn) {
    $msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
}
//$goto = "<input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/>";
$total_string = "<span class='srtotal' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span>";
//$msg = $msg . "</ul>" . $goto . $total_string . "</div>";  // Content for pagination
$msg = $msg . "</ul>" . $total_string . "</div>";  // Content for pagination
echo $msg;
}
}else{
	echo 'Error';
}