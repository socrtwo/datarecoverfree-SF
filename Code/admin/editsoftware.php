<?php define('TITLE','Edit Sofware Page'); require('includes/header.php'); ?>
<?php
require('includes/functions.php');
$checker = isset($_POST['checker']) ? mysql_real_escape_string($_POST['checker']) : '';

if ($checker == 'tester') {
	$id = isset($_POST['id']) ? mysql_real_escape_string($_POST['id']) : '';
    $title = isset($_POST['title']) ? mysql_real_escape_string($_POST['title']) : '';
    $tag = isset($_POST['tag']) ? mysql_real_escape_string($_POST['tag']) : '';	
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $os = isset($_POST['os']) ? mysql_real_escape_string($_POST['os']) : '';	
	$other_requirements = isset($_POST['other_requirements']) ? $_POST['other_requirements'] : '';
	$file_size = isset($_POST['file_size']) ? mysql_real_escape_string($_POST['file_size']) : '';	
	$software_url = isset($_POST['software_url']) ? mysql_real_escape_string($_POST['software_url']) : '';	
	$download_link = isset($_POST['download_link']) ? mysql_real_escape_string($_POST['download_link']) : '';	
	$category_id = isset($_POST['category_id']) ? mysql_real_escape_string($_POST['category_id']) : '';	
	$editor_rating = isset($_POST['editor_rating']) ? mysql_real_escape_string($_POST['editor_rating']) : '';	
	//$date_modified = date('m-d-Y');
	$date_modified = date('F d, Y');
	$icon = $_FILES['icon']['name'];
    $screenshot1 = $_FILES['screenshot1']['name'];

    $icon21 = mysql_real_escape_string(isset($_POST['icon11']) ? $_POST['icon11'] : '');
    $picture21 = mysql_real_escape_string(isset($_POST['picture11']) ? $_POST['picture11'] : '');
    $picture22 = mysql_real_escape_string(isset($_POST['picture12']) ? $_POST['picture12'] : '');
    $picture23 = mysql_real_escape_string(isset($_POST['picture13']) ? $_POST['picture13'] : '');
    $picture24 = mysql_real_escape_string(isset($_POST['picture14']) ? $_POST['picture14'] : '');
    $picture25 = mysql_real_escape_string(isset($_POST['picture15']) ? $_POST['picture15'] : '');

if ($id == '' || $title == '' || $os == '' || $description == '' || $file_size == '' || $software_url == '' || $download_link == '' || $category_id == '' || $editor_rating == '' ) {
        echo '<script type="text/javascript">' .
        'alert("Fields marked with (*) are required")' .
        '</script>';
    } else {
            $icon = $_FILES['icon']['name'];
            if (!empty($icon)) {
                $filename = stripslashes($_FILES['icon']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                    $icon11 = $icon21;
                } else {
                    $icon_name = time() . rand(0, 999) . '.' . $extension;
                    $newname = "../uploads/icons/" . $icon_name;
                    copy($_FILES['icon']['tmp_name'], $newname);
					$icon11 = $icon_name;
                    $newname01 = "../uploads/icons/thumbs/" . $icon_name;
                    make_thumb($newname, $newname01, '60', '60');
                }
            }else{
                $icon11 = $icon21;
            }

            $screenshot1 = $_FILES['screenshot1']['name'];
            if (!empty($screenshot1)) {
                $filename = stripslashes($_FILES['screenshot1']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                    $picture11 = $picture21;
                } else {
                    $image_name1 = time() . rand(0, 999) . '.' . $extension;
                    $newname1 = "../uploads/screenshots/" . $image_name1;
                    copy($_FILES['screenshot1']['tmp_name'], $newname1);
                    $picture11 = $image_name1;					
                    $newname11 = "../uploads/screenshots/large/" . $image_name1;
                    $newname12 = "../uploads/screenshots/medium/" . $image_name1;
                    $newname13 = "../uploads/screenshots/thumbs/" . $image_name1;
                    make_thumb($newname1, $newname11, '592', '450');
                    make_thumb($newname1, $newname12, '246', '175');
                    make_thumb($newname1, $newname13, '135', '148');
                }
            }else{
	            $picture11 = $picture21;
            }

            $screenshot2 = $_FILES['screenshot2']['name'];
            if (!empty($screenshot2)) {
                $filename = stripslashes($_FILES['screenshot2']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
	            	$picture12 = $picture22;
                } else {
                    $image_name2 = time() . rand(0, 999) . '.' . $extension;
                    $newname2 = "../uploads/screenshots/" . $image_name2;
                    copy($_FILES['screenshot2']['tmp_name'], $newname2);
					$picture12 = $image_name2;
                    $newname21 = "../uploads/screenshots/large/" . $image_name2;
                    $newname22 = "../uploads/screenshots/medium/" . $image_name2;
                    $newname23 = "../uploads/screenshots/thumbs/" . $image_name2;
                    make_thumb($newname2, $newname21, '592', '450');
                    make_thumb($newname2, $newname22, '246', '175');
                    make_thumb($newname2, $newname23, '135', '148');
                }
            }else{
	            $picture12 = $picture22;
            }
			
            $screenshot3 = $_FILES['screenshot3']['name'];
            if (!empty($screenshot3)) {
                $filename = stripslashes($_FILES['screenshot3']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
	            	$picture13 = $picture23;
                } else {
                    $image_name3 = time() . rand(0, 999) . '.' . $extension;
                    $newname3 = "../uploads/screenshots/" . $image_name3;
                    copy($_FILES['screenshot3']['tmp_name'], $newname3);
					$picture13 = $image_name3;
                    $newname31 = "../uploads/screenshots/large/" . $image_name3;
                    $newname32 = "../uploads/screenshots/medium/" . $image_name3;
                    $newname33 = "../uploads/screenshots/thumbs/" . $image_name3;
                    make_thumb($newname3, $newname31, '592', '450');
                    make_thumb($newname3, $newname32, '246', '175');
                    make_thumb($newname3, $newname33, '135', '148');
                }
            }else{
	        	$picture13 = $picture23;
            }
			
            $screenshot4 = $_FILES['screenshot4']['name'];
            if (!empty($screenshot4)) {
                $filename = stripslashes($_FILES['screenshot4']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
	        		$picture14 = $picture24;
                } else {
                    $image_name4 = time() . rand(0, 999) . '.' . $extension;
                    $newname4 = "../uploads/screenshots/" . $image_name4;
                    copy($_FILES['screenshot4']['tmp_name'], $newname4);
	        		$picture14 = $image_name4;
                    $newname41 = "../uploads/screenshots/large/" . $image_name4;
                    $newname42 = "../uploads/screenshots/medium/" . $image_name4;
                    $newname43 = "../uploads/screenshots/thumbs/" . $image_name4;
                    make_thumb($newname4, $newname41, '592', '450');
                    make_thumb($newname4, $newname42, '246', '175');
                    make_thumb($newname4, $newname43, '135', '148');
                }
            }else{
                $picture14 = $picture24;
            }
			
            $screenshot5 = $_FILES['screenshot5']['name'];
            if (!empty($screenshot5)) {
                $filename = stripslashes($_FILES['screenshot5']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$picture15 = $picture25;
                } else {
                    $image_name5 = time() . rand(0, 999) . '.' . $extension;
                    $newname5 = "../uploads/screenshots/" . $image_name5;
                    copy($_FILES['screenshot5']['tmp_name'], $newname5);
					$picture15 = $image_name5;
                    $newname51 = "../uploads/screenshots/large/" . $image_name5;
                    $newname52 = "../uploads/screenshots/medium/" . $image_name5;
                    $newname53 = "../uploads/screenshots/thumbs/" . $image_name5;
                    make_thumb($newname5, $newname51, '592', '450');
                    make_thumb($newname5, $newname52, '246', '175');
                    make_thumb($newname5, $newname53, '135', '148');
                }
            }else{
                $picture15 = $picture25;
            }						
			
            $updater = mysql_query("update `softwares` set `title`='$title', `tag`='$tag', `description`='$description', `os`='$os', `other_requirement`='$other_requirements', `file_size`='$file_size', `software_url`='$software_url', `download_link`='$download_link', `category_id`='$category_id', `editor_rating`='$editor_rating', `date_modified`='$date_modified', `icon`='$icon11', `screenshot1`='$picture11', `screenshot2`='$picture12', `screenshot3`='$picture13', `screenshot4`='$picture14', `screenshot5`='$picture15' where `id`='$id'");
            if ($updater)
                header('Location: softwares.php?info=Software Details Updated Successfully');
        }
}else{
	$id = isset($_GET['id'])?mysql_real_escape_string($_GET['id']):'';
	if($id == ''){
		header('Location: softwares.php');
	}
	else{
		$select_sql = mysql_query("select * from softwares where id='$id'");
		//print_r($select_sql);
		$res_sql = mysql_fetch_array($select_sql);
	
		//print_r($res_sql);
		if($res_sql==''){
		header('Location: softwares.php');
		}
	}
}
?>
        <link href="css/admin.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="js/wysiwyg.js"></script>
        <div id="admintablewrapper">
            <div class="formholder2">
                <div class="formholder3">
                    <form action="editsoftware.php" name="edit_software" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                    	<input type="hidden" value="<?php echo $res_sql['id']; ?>" name="id" />
                        <input type="hidden" value="tester" name="checker" />
                        <input type="hidden" name="icon11" value="<?php echo $res_sql['icon']; ?>" />
                        <input type="hidden" name="picture11" value="<?php echo $res_sql['screenshot1']; ?>" />
                        <input type="hidden" name="picture12" value="<?php echo $res_sql['screenshot2']; ?>" />
                        <input type="hidden" name="picture13" value="<?php echo $res_sql['screenshot3']; ?>" />
                        <input type="hidden" name="picture14" value="<?php echo $res_sql['screenshot4']; ?>" />
                        <input type="hidden" name="picture15" value="<?php echo $res_sql['screenshot5']; ?>" />
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Title <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="title" id="title" value="<?php echo $res_sql['title']; ?>" class="ip1" />
                            </div>
                        </div>
						<div class="fieldholder1">
                            <div class="fleft1"><span>Tag (or) Short Desc <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="tag" id="tag" value="<?php echo $res_sql['tag']; ?>" class="ip1" />
                            </div>
                        </div>                        
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Description <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <textarea id="description" name="description" style="height: 200px; width: 600px;">
                                <?php echo $res_sql['description']; ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>OS <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <select name="os" id="os" class="sp1">
                                <option value="" <?php if($res_sql['os']=='') echo 'selected="selected"'; ?>>Select</option>
								<?php
                                $sql = mysql_query("select * from `os` order by `id` desc");
                                if(mysql_num_rows($sql)>0){
                                    while($res = mysql_fetch_array($sql)){
										if($res_sql['os']==$res['id'])
	                                        echo '<option value="'.$res['id'].'" selected="selected">'.$res['name'].'</option>';
										else
											echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
                                    }
                                }
                                ?>                                
                                </select>                                
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Other Requirements :</span></div>
                            <div class="fright1">
                                <textarea id="other_requirements" name="other_requirements" style="height: 200px; width: 600px;">
                                <?php echo $res_sql['other_requirement']; ?>
                                </textarea>
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>File Size <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="file_size" id="file_size" value="<?php echo $res_sql['file_size']; ?>" class="ip1" />
                            </div>
                        </div>     
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Software URL <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="software_url" id="software_url" value="<?php echo $res_sql['software_url']; ?>" class="ip1" />
                            </div>
                        </div>                             
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Download Link <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="download_link" id="download_link" value="<?php echo $res_sql['download_link']; ?>" class="ip1" />
                            </div>
                        </div>                       
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Category Id <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <select name="category_id" id="category_id" class="sp1">
                                <option value="" <?php if($res_sql['category_id']=='') echo 'selected="selected"'; ?>>Select</option>
								<?php
                                $sql = mysql_query("select * from `categories` where `parentid`!='0' order by `id` desc");
                                if(mysql_num_rows($sql)>0){
                                    while($res = mysql_fetch_array($sql)){
										if($res_sql['category_id']==$res['id'])										
	                                        echo '<option value="'.$res['id'].'" selected="selected">'.$res['name'].'</option>';
										else
											echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
                                    }
                                }
                                ?>                                
                                </select>
                            </div>
                        </div>  
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Editor Rating <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <select name="editor_rating" id="editor_rating" class="sp1">
                                <option value="" <?php if($res_sql['editor_rating']=='') echo 'selected="selected"'; ?>>Select</option>
                                <option value="1" <?php if($res_sql['editor_rating']=='1') echo 'selected="selected"'; ?>>1</option>
                                <option value="2" <?php if($res_sql['editor_rating']=='2') echo 'selected="selected"'; ?>>2</option>
                                <option value="3" <?php if($res_sql['editor_rating']=='3') echo 'selected="selected"'; ?>>3</option>
                                <option value="4" <?php if($res_sql['editor_rating']=='4') echo 'selected="selected"'; ?>>4</option>
                                <option value="5" <?php if($res_sql['editor_rating']=='5') echo 'selected="selected"'; ?>>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Icon :</span></div>
                            <div class="fright1">
                                <input type="file" name="icon" id="icon" class="ip1" />
								<?php if ($res_sql['icon'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/icons/thumbs/<?php echo $res_sql['icon']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictname=<?php echo $res_sql['icon']; ?>&key=del_icon">Delete</a>
								<?php } ?>                                
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 1 <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot1" id="screenshot1" class="ip1" />
								<?php if ($res_sql['screenshot1'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/screenshots/thumbs/<?php echo $res_sql['screenshot1']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictid=1&pictname=<?php echo $res_sql['screenshot1']; ?>&key=del_img">Delete</a>
								<?php } ?>                                  
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 2 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot2" id="screenshot2" class="ip1" />
								<?php if ($res_sql['screenshot2'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/screenshots/thumbs/<?php echo $res_sql['screenshot2']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictid=2&pictname=<?php echo $res_sql['screenshot2']; ?>&key=del_img">Delete</a>
								<?php } ?>                                  
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 3 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot3" id="screenshot3" class="ip1" />
								<?php if ($res_sql['screenshot3'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/screenshots/thumbs/<?php echo $res_sql['screenshot3']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictid=3&pictname=<?php echo $res_sql['screenshot3']; ?>&key=del_img">Delete</a>
								<?php } ?>                                   
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 4 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot4" id="screenshot4" class="ip1" />
								<?php if ($res_sql['screenshot4'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/screenshots/thumbs/<?php echo $res_sql['screenshot4']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictid=4&pictname=<?php echo $res_sql['screenshot4']; ?>&key=del_img">Delete</a>
								<?php } ?>                                   
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 5 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot5" id="screenshot5" class="ip1" />
								<?php if ($res_sql['screenshot5'] == '') {
                                    
                                } else { ?>
                                    <br /><img src="../uploads/screenshots/thumbs/<?php echo $res_sql['screenshot5']; ?>" alt="" /><br />
                                    <a href="includes/functions.php?pictid=5&pictname=<?php echo $res_sql['screenshot5']; ?>&key=del_img">Delete</a>
								<?php } ?>                                   
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>&nbsp;</span></div>
                            <div class="fright1">
                                <input type="submit" value="Save" />
                                <input type="reset" value="Clear" />
                            </div>
                        </div>
                    </form>

                    <script language="javascript" type="text/javascript">
                        function validate()
                        {
                            var form1 = document.edit_software;
                            var title = form1.title.value;	
                            var tag = form1.tag.value;								
                            var description = $("#description").val();
							var os = form1.os.value;
							var file_size = form1.file_size.value;
							var software_url = form1.software_url.value;
							var download_link = form1.download_link.value;
							var category_id = form1.category_id.value;
							var editor_rating = form1.editor_rating.value;
                            var screenshot1 = form1.screenshot1.value;
                            //alert(image1);
                           
                         if(title=='' || tag=='' || description=='' || os=='' || file_size=='' || software_url=='' || download_link=='' || category_id=='' || editor_rating=='')
                            {
                                alert("Fields marked with (*) are required");
                                return false;
                            }
                            else
                            {
                                return true;
                            }
                        }
                    </script> 

                    <script language="javascript1.2">
                        generate_wysiwyg('description');
                        generate_wysiwyg('other_requirements');						
                    </script>       
                </div></div></div>
<?php require('includes/footer.php'); ?>