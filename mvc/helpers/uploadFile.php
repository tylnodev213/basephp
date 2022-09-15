<?php
function uploadFile()
{
    
    $msg = "";

    if ($_FILES['avatar']['name'] != '') {
        if(isset($_POST['old_avatar'])){
            unlink("../basephp/helpers/img".$_POST['old_avatar']);
        }
        $filename = $_FILES["avatar"]["name"];
        $template = $_FILES["avatar"]["tmp_name"];
        $extension = explode(".", $filename);
        $file_extension = strtolower(end($extension));
        $allowed_type = array("jpg", "jpeg", "png", "gif");
        if (in_array($file_extension, $allowed_type)) {
            $new_name = rand() . "." . $file_extension;
            $folder = "../basephp/public/img/" . $new_name;
            move_uploaded_file($template, $folder);
            return $new_name;
        } else {
            return false;
        }
    }else if(isset($_POST['old_avatar'])){
        return $_POST['old_avatar'];
    }
}
