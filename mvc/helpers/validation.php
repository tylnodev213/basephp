<?php

function validateBlank($input = '')
{
    if ($input == "") 
    {
        return false;
    }
    return true;
}

function validateEmail($email = '')
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        return false;
    }
    return true;
}

function validation($input = [])
{
    //check email blank
    if (!validateBlank($input['email'])) 
    {
        setSessionMessage('Email', INPUT_BLANK);
        return false;
    }
    // check email valid
    if (!validateEmail($input['email'])) 
    {
        setSessionMessage('Email', EMAIL_NOT_VALID);
        return false;
    }
    //check password blank
    if (!validateBlank($input['password'])) 
    {
        setSessionMessage('Password', INPUT_BLANK);
        return false;
    }
    return true;
}


