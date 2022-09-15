<?php

function validateBlank($input): int
{
    if (strlen($input)==0)
    {
        return 0;
    }
    return 1;
}

function validateEmail($email = ''): int
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        return 0;
    }
    return 1;
}

function validation($input = []): int
{
    $check = 0;
    //check email blank
    if (!validateBlank($input['email']))
    {
        setSessionMessage('Email', INPUT_BLANK);
        $check++;
    }
    // check email valid
    if (!validateEmail($input['email']))
    {
        setSessionMessage('Email', EMAIL_NOT_VALID);
        $check++;
    }
    //check password blank
    if (!validateBlank($input['password']))
    {
        setSessionMessage('Password', INPUT_BLANK);
        $check++;
    }
    if($check==0){
        return 1;
    }
    return 0;
}


