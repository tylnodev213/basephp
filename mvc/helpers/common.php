<?php

function setSessionAdmin($key, $value)
{
    $_SESSION['admin'][$key] = $value;
}

function getSessionAdmin($key)
{
    return $_SESSION['admin'][$key];
}

function setSessionUser($key, $value)
{
    $_SESSION['user'][$key] = $value;
}

function getSessionUser($key)
{
    return $_SESSION['user'][$key];
}

function checkSessionLogin($entity): bool
{
    return !empty($_SESSION[$entity]['id']);
}

function setSessionMessage($input, $message)
{
    $_SESSION['message'][$input] = $input." ".$message;
}

function getSessionMessage($input)
{
    return $_SESSION['message'][$input];
}

function checkSessionMessage($input): bool
{
    return !empty($_SESSION['message'][$input]);
}

function unsetSessionMessage($input)
{
    unset($_SESSION['message'][$input]);
}

function setSessionActionSuccessful($action)
{
    $_SESSION['actionSuccessfully'] = $action." Successfully";
}

function getSessionActionSuccessful()
{
    return $_SESSION['actionSuccessfully'];
}

function checkSessionActionSuccessful(): bool
{
    return !empty($_SESSION['actionSuccessfully']);
}

function unsetSessionActionSuccessful()
{
    unset($_SESSION['actionSuccessfully']);
}

