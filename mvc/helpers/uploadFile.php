<?php
function uploadFile()
{

    if ($_FILES['avatar']['name'] != '') {
        if( !empty($_POST['old_avatar']) &&file_exists("../basephp/public/img/".$_POST['old_avatar']) ) {
            unlink("../basephp/public/img/" . $_POST['old_avatar']);
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
            setSessionMessage('Avatar', FILE_NOT_VALID. implode(', ',$allowed_type));
            return false;
        }
    }

    if(isset($_POST['old_avatar'])) {
        return $_POST['old_avatar'];
    }
    setSessionMessage('Avatar', INPUT_BLANK);
}
