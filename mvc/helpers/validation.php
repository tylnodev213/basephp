<?php

function validateBlank($input): int
{
    if (strlen($input)==0)
    {
        return 0;
    }
    return 1;
}

function validateLength($input, $maxLength, $minLength): int
{
    if ( strlen($input) > $maxLength || strlen($input) < $minLength )
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
    // check email valid
    if (isset($input['email']) && !validateEmail($input['email']))
    {
        setSessionMessage('Email', EMAIL_NOT_VALID);
        $check++;
    }

    // password verify
    if (isset($input['password_verify']) &&  strcmp($input['password'],$input['password_verify']))
    {
        setSessionMessage('Password_verify', PASSWORD_VERIFY);
        $check++;
    }

    //validate input length
    if(isset($input['name']) && !validateLength($input['name'],128,1) )
    {
        setSessionMessage('Name', INPUT_MAX_LENGTH.' 128 characters');
        $check++;
    }

    if(isset($input['email']) && !validateLength($input['email'],128,1) )
    {
        setSessionMessage('Email', INPUT_MAX_LENGTH.' 128 characters');
        $check++;
    }

    if(isset($input['password']) && !validateLength($input['password'],100,3) )
    {
        setSessionMessage('Password', INPUT_MIN_LENGTH.' 3 characters and'. INPUT_MAX_LENGTH.' 100 characters ');
        $check++;
    }

    if(isset($input['password_verify']) && !validateLength($input['password_verify'],100,3) )
    {
        setSessionMessage('Password', INPUT_MIN_LENGTH.' 3 characters and'. INPUT_MAX_LENGTH.' 100 characters ');
        $check++;
    }

    //check email blank
    if (isset($input['name']) && !validateBlank($input['name']))
    {
        setSessionMessage('Name', INPUT_BLANK);
        $check++;
    }

    if (isset($input['email']) &&  !validateBlank($input['email']))
    {
        setSessionMessage('Email', INPUT_BLANK);
        $check++;
    }

    if (isset($input['password']) &&  !validateBlank($input['password']))
    {
        setSessionMessage('Password', INPUT_BLANK);
        $check++;
    }

    if (isset($input['password_verify']) &&  !validateBlank($input['password_verify']))
    {
        setSessionMessage('Password_verify', INPUT_BLANK);
        $check++;
    }

    if (isset($input['role_type']) &&  !validateBlank($input['role_type']))
    {
        setSessionMessage('Role', NOT_SELECT);
        $check++;
    }

    if (isset($input['status']) &&  !validateBlank($input['status']))
    {
        setSessionMessage('Status', NOT_SELECT);
        $check++;
    }

    if($check==0){
        return 1;
    }
    return 0;
}


