<?php
function resetForm()
{
$_GET = array();
header("Location: search");
exit;
}

if (isset($_GET['submit'])) {
resetForm();
}
?>