<?php
/*
Demo: AJAX Search Suggest (WeAreHunted.com Style)
Version 1.0
Author: Ian Lunn
Author URL: http://www.ianlunn.co.uk/
Demo URL: http://www.ianlunn.co.uk/demos/ajax-search-suggest-wearehunted/
Tutorial URL: http://www.ianlunn.co.uk/blog/code-tutorials/ajax-search-suggest-wearehunted/
GitHub: https://github.com/IanLunn/AJAX-Search-Suggest--WeAreHunted.com-Style-/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

//include ("test-data.php"); //include the array that contains our example search results (in the real world, you'd connect to and query a database)
require('includes/configure.php');

if(isset($_POST['latestQuery'])){ //if the auto-suggest script receives a query...

	$latestQuery = $_POST['latestQuery']; //save the query in a variable
	$latestQueryLength = strlen($latestQuery); //count the number of characters in that query
	$result = array(); //set up an array that we'll store the matched search terms in (and finally send back to the JavaScript)
	$data = array();
	
	if(empty($data)){
	$sql = mysql_query("select `id`,`title` from `softwares`");
	if(mysql_num_rows($sql)>0){
			while($res = mysql_fetch_array($sql)){
				$ltit = preg_replace("/^[^a-z0-9]?(.*?)[^a-z0-9]?$/i", "$1", $res['title']);
				$url = URL . 'software/' . strtolower(str_replace(' ','-',str_replace('.','',$ltit))) .'/'. $res['id'];
				$data[$res['title']] = $url;
			}
	}
	}
	
	 foreach($data as $name => $url){ //for each value in the data array...
		if (substr(strtolower($name),0,$latestQueryLength) == strtolower($latestQuery)){ //check to see if the query matches any search terms, if it does...
				$result[$name] = $url; //add the term as a key and the url as it's value. example: ACDC : "?search=ACDC"
		}
	}
	
	echo json_encode($result); //encode the results list as a JavaScript object, and send it back to the JavaScript
}
?>