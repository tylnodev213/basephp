<?php
function resetForm()
{
    if (isset($_GET['submit'])) {
        $_GET = array();
        header("Location: search");
        return;
    }
    if (isset($_POST['old_avatar'])) {
        removeFile($_POST['old_avatar']);
    }
    $_POST = array();
    header("Refresh:0");
    exit;
}

if (isset($_GET['submit']) || isset($_POST['submit'])) {
    resetForm();
}
?>