<?php
//get all rows
$query = mysqli_query($link,'SELECT * FROM categories');
while ( $row = mysqli_fetch_assoc($query) )
{
	$menu_array[$row['id']] = array('id' => $row['id'], 'name' => $row['name'],'parent' => $row['parentid']);
}

//recursive function that prints categories as a nested html unorderd list
function generate_menu($parent)
{

	$has_childs = false;
	$first = true;
	//this prevents printing 'ul' if we don't have subcategories for this category

	global $menu_array;
	//use global array variable instead of a local variable to lower stack memory requierment

	foreach($menu_array as $key => $value)
	{
			if ($value['parent'] == $parent) 
			{       //print_r($value);
					//if this is the first child print '<ul>'                       
					if ($has_childs === false)
					{
							//don't print '<ul>' multiple times
							$has_childs = true;
							if($first === true)
								echo '<ul id="suckertree1">';
							else
								echo '<ul>';
								
					}
					
					if($value['parent'] == '0')
						echo '<li><a href="'.URL.'category/' . strtolower(str_replace('.','',str_replace(',','',str_replace('/','',str_replace(' ','-',$value['name']))))) . '/' . $value['id'] . '/">' . $value['name'] . '</a>';
					else
						echo '<li><a href="'.URL.'sub-category/' . strtolower(str_replace('.','',str_replace(',','',str_replace('/','',str_replace(' ','-',$value['name']))))) . '/' . $value['id'] . '/">' . $value['name'] . '</a>';
					
					generate_menu($key);
					//call function again to generate nested list for subcategories belonging to this category
					echo '</li>';
			}
	}
	if ($has_childs === true) echo '</ul>';
}

//function for os menu creation in left side
function generate_os_menu(){
$sql = mysql_query("select DISTINCT `os` from `softwares` where `os`!='NA' AND `os`!='Not available' AND `os`!='Not applicable' AND `os`!='0' order by id desc limit 0,5");
if(mysql_num_rows($sql)>0){
	echo '<ul>';
	while($res = mysql_fetch_array($sql)){
		echo '<li><a href="'.URL.'popularsearch/' . strtolower(str_replace(',','=',str_replace(' ','-',$res['os']))) . '/">'.$res['os'].'</a></li>';
	}
	echo '<li><a href="'.URL.'popularsearch_all/">More...</a></li>';
	echo '</ul>';	
}else{
	echo '<ul>';
	echo '<li style="padding:10px 0px;">No Results</li>';
	echo '</ul>';
}
}

//function for links menu creation in right side
function generate_links_menu(){
$sql = mysql_query("select * from `links` order by id asc");
if(mysql_num_rows($sql)>0){
	echo '<ul>';
	while($res = mysql_fetch_array($sql)){
		echo '<li><a href="'.$res['link'].'" target="_blank">'.$res['name'].'</a></li>';
	}
	echo '</ul>';	
}else{
	echo '<ul>';
	echo '<li style="padding:10px 0px;">No Results</li>';
	echo '</ul>';
}
}

//function for short description
function shorten($string, $length)
{
    // By default, an ellipsis will be appended to the end of the text.
    $suffix = '&hellip;';
 
    // Convert 'smart' punctuation to 'dumb' punctuation, strip the HTML tags,
    // and convert all tabs and line-break characters to single spaces.
    $short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
 
    // Cut the string to the requested length, and strip any extraneous spaces 
    // from the beginning and end.
    $desc = trim(substr($short_desc, 0, $length));
 
    // Find out what the last displayed character is in the shortened string
    $lastchar = substr($desc, -1, 1);
 
    // If the last character is a period, an exclamation point, or a question 
    // mark, clear out the appended text.
    if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
 
    // Append the text.
    $desc .= $suffix;
 
    // Send the new description back to the page.
    return $desc;
}

function get_crumbs($this_cat_id, $flarn, $keep_cat_id) {

$link_to_page=$_SERVER['PHP_SELF'];
if (!isset($this_cat_id)) {
// if we are already "home", dont make home a link
$this_cat_id ="0";
echo 'You are here: <a href="'. URL .'home/">Home</a> / ';
}
// get the info and parent id for whatever category
// we're currently in

$sql = "SELECT id, parentid, name from categories ";
$sql .="where id = $this_cat_id";

$show_crumb_trail = mysql_query($sql);
$num_crumbs = mysql_num_rows($show_crumb_trail);

// if we actually have some results….
if ($num_crumbs > 0) {
list($cat_id, $cat_parent, $cat_name) = mysql_fetch_row($show_crumb_trail);
$cat_id_array[$flarn] = $cat_id;
$cat_parent_id_array[$flarn] = $cat_parent;
$cat_name_array[$flarn] = $cat_name;
if ($cat_id_array[$flarn] > 0) {
mysql_free_result($show_crumb_trail);
// increment $next by one
$next = $flarn+1;
if ($flarn == 0 ) {
echo 'You are here: <a href="'. URL .'home/">Home</a> / ';
}

get_crumbs($cat_parent_id_array[$flarn], $next, $keep_cat_id);

if($cat_parent_id_array[$flarn]==0){
if ($keep_cat_id==$cat_id_array[$flarn]) {
	echo '<a href="'.URL.'category/' . strtolower(str_replace(' ','-',$cat_name_array[$flarn])) . '/' . $cat_id_array[$flarn].'">'.$cat_name_array[$flarn].'</a>';
} else {
	echo '<a href="'.URL.'category/' . strtolower(str_replace(' ','-',$cat_name_array[$flarn])) . '/' . $cat_id_array[$flarn].'">'.$cat_name_array[$flarn].' / </a>';
}
}else{
if ($keep_cat_id==$cat_id_array[$flarn]) {
	echo '<a href="'.URL.'sub-category/' . strtolower(str_replace(' ','-',$cat_name_array[$flarn])) . '/' . $cat_id_array[$flarn].'">'.$cat_name_array[$flarn].'</a>';
} else {
	echo '<a href="'.URL.'sub-category/' . strtolower(str_replace(' ','-',$cat_name_array[$flarn])) . '/' . $cat_id_array[$flarn].'">'.$cat_name_array[$flarn].' / </a>';
}	
} } } }
?>