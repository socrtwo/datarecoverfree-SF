<?php define('TITLE','Add Sofware Page'); require('includes/header.php'); ?>
<?php
require('includes/functions.php');
$checker = isset($_POST['checker']) ? mysql_real_escape_string($_POST['checker']) : '';

if ($checker == 'tester') {
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

    if ($title == '' || $os == '' || $description == '' || $file_size == '' || $software_url == '' || $download_link == '' || $category_id == '' || $editor_rating == '' || $screenshot1 == '' ) {
        echo '<script type="text/javascript">' .
        'alert("Fields marked with (*) are required")' .
        '</script>';
    } else {
        $ins_sql = "INSERT INTO `softwares` (`id`, `title`, `tag`, `description`, `os`, `other_requirement`, `file_size`, `software_url`, `download_link`, `category_id`, `editor_rating`, `date_modified`) VALUES (NULL, '$title', '$tag', '$description', '$os', '$other_requirements', '$file_size', '$software_url', '$download_link', '$category_id', '$editor_rating', '$date_modified')";
        $ins_sql1 = mysql_query($ins_sql);
        if ($ins_sql1) {
            $insert_id = mysql_insert_id();
            
            $icon = $_FILES['icon']['name'];
            if (!empty($icon)) {
                $filename = stripslashes($_FILES['icon']['name']);
				//get the extension of the file in a lower case format
                $extension = getExtension($filename);
                $extension = strtolower($extension);
				//if it is not a known extension, we will suppose it is an error and will not  upload the file,  
				//otherwise we will do more tests
                if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $icon_name = time() . rand(0, 999) . '.' . $extension;
                    $newname = "../uploads/icons/" . $icon_name;
                    copy($_FILES['icon']['tmp_name'], $newname);
                    $newname01 = "../uploads/icons/thumbs/" . $icon_name;
                    make_thumb($newname, $newname01, '60', '60');
                }
            }else{
                $icon_name = '';
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
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $image_name1 = time() . rand(0, 999) . '.' . $extension;
                    $newname1 = "../uploads/screenshots/" . $image_name1;
                    copy($_FILES['screenshot1']['tmp_name'], $newname1);
                    $newname11 = "../uploads/screenshots/large/" . $image_name1;
                    $newname12 = "../uploads/screenshots/medium/" . $image_name1;
                    $newname13 = "../uploads/screenshots/thumbs/" . $image_name1;
                    make_thumb($newname1, $newname11, '592', '450');
                    make_thumb($newname1, $newname12, '246', '175');
                    make_thumb($newname1, $newname13, '135', '148');
                }
            }else{
                $image_name1 = '';
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
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $image_name2 = time() . rand(0, 999) . '.' . $extension;
                    $newname2 = "../uploads/screenshots/" . $image_name2;
                    copy($_FILES['screenshot2']['tmp_name'], $newname2);
                    $newname21 = "../uploads/screenshots/large/" . $image_name2;
                    $newname22 = "../uploads/screenshots/medium/" . $image_name2;
                    $newname23 = "../uploads/screenshots/thumbs/" . $image_name2;
                    make_thumb($newname2, $newname21, '592', '450');
                    make_thumb($newname2, $newname22, '246', '175');
                    make_thumb($newname2, $newname23, '135', '148');
                }
            }else{
                $image_name2 = '';
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
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $image_name3 = time() . rand(0, 999) . '.' . $extension;
                    $newname3 = "../uploads/screenshots/" . $image_name3;
                    copy($_FILES['screenshot3']['tmp_name'], $newname3);
                    $newname31 = "../uploads/screenshots/large/" . $image_name3;
                    $newname32 = "../uploads/screenshots/medium/" . $image_name3;
                    $newname33 = "../uploads/screenshots/thumbs/" . $image_name3;
                    make_thumb($newname3, $newname31, '592', '450');
                    make_thumb($newname3, $newname32, '246', '175');
                    make_thumb($newname3, $newname33, '135', '148');
                }
            }else{
                $image_name3 = '';
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
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $image_name4 = time() . rand(0, 999) . '.' . $extension;
                    $newname4 = "../uploads/screenshots/" . $image_name4;
                    copy($_FILES['screenshot4']['tmp_name'], $newname4);
                    $newname41 = "../uploads/screenshots/large/" . $image_name4;
                    $newname42 = "../uploads/screenshots/medium/" . $image_name4;
                    $newname43 = "../uploads/screenshots/thumbs/" . $image_name4;
                    make_thumb($newname4, $newname41, '592', '450');
                    make_thumb($newname4, $newname42, '246', '175');
                    make_thumb($newname4, $newname43, '135', '148');
                }
            }else{
                $image_name4 = '';
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
                    echo '<script type="text/javascript">' .
                    'alert("Invalid Image File")' .
                    '</script>';
                    mysql_query("delete from `softwares` where `id`='$insert_id'");
                } else {
                    $image_name5 = time() . rand(0, 999) . '.' . $extension;
                    $newname5 = "../uploads/screenshots/" . $image_name5;
                    copy($_FILES['screenshot5']['tmp_name'], $newname5);
                    $newname51 = "../uploads/screenshots/large/" . $image_name5;
                    $newname52 = "../uploads/screenshots/medium/" . $image_name5;
                    $newname53 = "../uploads/screenshots/thumbs/" . $image_name5;
                    make_thumb($newname5, $newname51, '592', '450');
                    make_thumb($newname5, $newname52, '246', '175');
                    make_thumb($newname5, $newname53, '135', '148');
                }
            }else{
                $image_name5 = '';
            }												
            
            $updater = mysql_query("update `softwares` set `icon`='$icon_name', `screenshot1`='$image_name1', `screenshot2`='$image_name2', `screenshot3`='$image_name3', `screenshot4`='$image_name4', `screenshot5`='$image_name5' where `id`='$insert_id'");
            if ($updater)
                header('Location: softwares.php?info=Software Details Added Successfully');
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
                    <form action="addsoftware.php" name="add_software" method="post" onsubmit="return validate()" enctype="multipart/form-data">
                        <input type="hidden" value="tester" name="checker" />
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Title <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="title" id="title" value="" class="ip1" />
                            </div>
                        </div>
						<div class="fieldholder1">
                            <div class="fleft1"><span>Tag (or) Short Desc <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="tag" id="tag" value="" class="ip1" />
                            </div>
                        </div>                        
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Description <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <textarea id="description" name="description" style="height: 200px; width: 600px;">
                                </textarea>
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>OS <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <select name="os" id="os" class="sp1">
                                <option value="" selected="selected">Select</option>
								<?php
                                $sql = mysql_query("select * from `os` order by `id` desc");
                                if(mysql_num_rows($sql)>0){
                                    while($res = mysql_fetch_array($sql)){
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
                                </textarea>
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>File Size <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="file_size" id="file_size" value="" class="ip1" />
                            </div>
                        </div>     
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Software URL <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="software_url" id="software_url" value="" class="ip1" />
                            </div>
                        </div>                             
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Download Link <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="text" name="download_link" id="download_link" value="" class="ip1" />
                            </div>
                        </div>                       
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Category Id <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <select name="category_id" id="category_id" class="sp1">
                                <option value="" selected="selected">Select</option>
								<?php
                                $sql = mysql_query("select * from `categories` where `parentid`!='0' order by `id` desc");
                                if(mysql_num_rows($sql)>0){
                                    while($res = mysql_fetch_array($sql)){
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
                                <option value="" selected="selected">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Icon :</span></div>
                            <div class="fright1">
                                <input type="file" name="icon" id="icon" class="ip1" />
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 1 <font color="#FF0000">*</font> :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot1" id="screenshot1" class="ip1" />
                            </div>
                        </div>
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 2 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot2" id="screenshot2" class="ip1" />
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 3 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot3" id="screenshot3" class="ip1" />
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 4 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot4" id="screenshot4" class="ip1" />
                            </div>
                        </div>                                                
                        <div class="fieldholder1">
                            <div class="fleft1"><span>Screenshot 5 :</span></div>
                            <div class="fright1">
                                <input type="file" name="screenshot5" id="screenshot5" class="ip1" />
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
                            var form1 = document.add_software;
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
                           
                            if(title=='' || tag=='' || description=='' || os=='' || file_size=='' || software_url=='' || download_link=='' || category_id=='' || editor_rating=='' || screenshot1=='')
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