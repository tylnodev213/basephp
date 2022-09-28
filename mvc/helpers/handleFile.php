<?php
function uploadFile()
{
    if ($_FILES['avatar']['name'] != '') {

        $filename = $_FILES["avatar"]["name"];


        $extension = explode(".", $filename);

        $file_extension = strtolower(end($extension));
        $allowed_type = array("jpg", "jpeg", "png", "gif");

        if(file_exists("../basephp/public/img/".$filename)) {
            return $filename;
        }

        if (in_array($file_extension, $allowed_type)) {
            $new_name = rand().".".$file_extension;
            saveFile($new_name);
            return $new_name;

        }

        setSessionMessage('Avatar', FILE_NOT_VALID.implode(', ', $allowed_type));
        return false;

    }

    if (!empty($_POST['old_avatar'])) {
        return $_POST['old_avatar'];
    }
    setSessionMessage('Avatar', INPUT_BLANK);
}

function saveFile($avatar)
{
    $template = $_FILES["avatar"]["tmp_name"];
    $folder = "../basephp/public/img/".$avatar;

    move_uploaded_file($template, $folder);
}

function removeFile($avatar)
{
    if (!empty($avatar) && file_exists("../basephp/public/img/".$avatar)) {
        unlink("../basephp/public/img/".$avatar);
    }
}
