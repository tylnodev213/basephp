<?php
if (!checkSessionLogin('admin') || !checkSessionLogin('user')) {
    header('Location: '.DOMAIN);
    return;
}

$permission = $_SESSION['admin']['role_type'] ?? "";
if ($permission != '0') {
    header('Location: '.DOMAIN);
    return;
}

$permission = $_SESSION['user']['status'] ?? "";
if ($permission != '0') {
    header('Location: '.DOMAIN);
    return;
}

?>