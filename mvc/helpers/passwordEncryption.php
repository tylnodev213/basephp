<?php

function passwordEncryption($password)
{

    $crypt = md5($password);

    return $crypt;
}

function phpAlert($msg, $controller) {
    echo '<script type="text/javascript">alert("' . $msg . '");window.location = "'.DOMAIN.$controller."/search".'";</script>';
}

?>