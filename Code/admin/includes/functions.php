<?php
include_once('common.php');
$key = isset($_REQUEST['key'])?$_REQUEST['key']:'';
function make_thumb($img_name, $filename, $new_w, $new_h) {
//get image extension.
    $ext = getExtension($img_name);
//creates the new image using the appropriate function from gd library
    if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
        $src_img = imagecreatefromjpeg($img_name);

    if (!strcmp("png", $ext))
        $src_img = imagecreatefrompng($img_name);

//gets the dimmensions of the image
    $old_x = imageSX($src_img);
    $old_y = imageSY($src_img);

// next we will calculate the new dimmensions for the thumbnail image
// the next steps will be taken:
// 1. calculate the ratio by dividing the old dimmensions with the new ones
// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
// and the height will be calculated so the image ratio will not change
// 3. otherwise we will use the height ratio for the image
// as a result, only one of the dimmensions will be from the fixed ones
    $ratio1 = $old_x / $new_w;
    $ratio2 = $old_y / $new_h;
    if ($ratio1 > $ratio2) {
        $thumb_w = $new_w;
        $thumb_h = $old_y / $ratio1;
    } else {
        $thumb_h = $new_h;
        $thumb_w = $old_x / $ratio2;
    }

// we create a new image with the new dimmensions
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

// resize the big image to the new created one
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);

// output the created image to the file. Now we will have the thumbnail into the file named by $filename
    if (!strcmp("png", $ext))
        imagepng($dst_img, $filename);
    else
        imagejpeg($dst_img, $filename);

//destroys source and destination images.
    imagedestroy($dst_img);
    imagedestroy($src_img);
}

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

if ($key == 'del_icon') {
    $ref = $_SERVER['HTTP_REFERER'];

    $pictid = 'icon';
    $pictname = isset($_REQUEST['pictname']) ? $_REQUEST['pictname'] : '';

    $thumb_dir = "../../uploads/icons/thumbs/";
    $img_dir = "../../uploads/icons/";
    $med_dir = "../../uploads/icons/medium/";
    $larg_dir = "../../uploads/icons/large/";

    $update_res = mysql_query("update `softwares` set `$pictid`='' WHERE `$pictid`='$pictname'") or die(mysql_error());

    if ($update_res) {
        if (file_exists($thumb_dir . $pictname)) {
            unlink($thumb_dir . $pictname);
            unlink($img_dir . $pictname);
            unlink($larg_dir . $pictname);
            unlink($med_dir . $pictname);
        }
    }

    header('Location: ' . $ref);
}

if ($key == 'del_img') {
    $ref = $_SERVER['HTTP_REFERER'];

    $pictid = isset($_REQUEST['pictid']) ? $_REQUEST['pictid'] : '';
    $pictid = 'screenshot' . $pictid;
    $pictname = isset($_REQUEST['pictname']) ? $_REQUEST['pictname'] : '';

    $thumb_dir = "../../uploads/screenshots/thumbs/";
    $img_dir = "../../uploads/screenshots/";
    $med_dir = "../../uploads/screenshots/medium/";
    $larg_dir = "../../uploads/screenshots/large/";

    $update_res = mysql_query("update `softwares` set `$pictid`='' WHERE `$pictid`='$pictname'") or die(mysql_error());

    if ($update_res) {
        if (file_exists($thumb_dir . $pictname)) {
            unlink($thumb_dir . $pictname);
            unlink($img_dir . $pictname);
            unlink($larg_dir . $pictname);
            unlink($med_dir . $pictname);
        }
    }

    header('Location: ' . $ref);
}
?>