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

function checkAdminLogin()
{
	return !empty(getSessionAdmin('id'));
}

function checkUserLogin()
{
	return !empty(getSessionUser('id'));
}
