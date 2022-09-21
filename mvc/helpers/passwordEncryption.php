<?php

function passwordEncryption($password)
{

    $crypt = md5($password);

    return $crypt;
}

?>