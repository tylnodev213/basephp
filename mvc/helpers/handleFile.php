<?php

function uploadFile()
{
    if ($_FILES['avatar']['name'] != '') {

        $filename = $_FILES["avatar"]["name"];
        // check file existed
        if(file_exists("../basephp/public/img/".$filename)) {
            return $filename;
        }
        // check file's size
        $filesize   = 1000000;
        if ($_FILES["avatar"]["size"] > $filesize)
        {
            setSessionMessage('Avatar', FILE_TOO_BIG);
            return false;
        }
        // check extension of file
        $extension = explode(".", $filename);
        // get extension of file
        $file_extension = strtolower(end($extension));

        $allowed_type = array("jpg", "jpeg", "png", "gif");

        if (in_array($file_extension, $allowed_type)) {
            // change file's name
            $new_name = rand().".".$file_extension;
            // save file
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
