<?php

function checkPermission(): bool
{
    if (!checkSessionLogin('admin') && !checkSessionLogin('user')) {
        return 0;
    }

    $permission = $_SESSION['admin']['role_type'] ?? $_SESSION['user']['status'];
    if (isset($permission) && $permission != '1') {
        return 0;
    }
    return 1;
}


?>