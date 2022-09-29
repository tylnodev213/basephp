<?php

function checkPermission($controller): bool
{
    if (!checkSessionLogin($controller)) {
        return 0;
    }
    if($controller == 'admin') {
        $permission = $_SESSION['admin']['role_type'];
    }else {
        $permission = $_SESSION['user']['status'];
    }

    if (isset($permission) && $permission != '1') {
        return 0;
    }
    return 1;
}


?>