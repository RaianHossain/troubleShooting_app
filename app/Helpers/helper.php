<?php

function check()
{
    return 'check';
}

function is_Engineer()
{
    if(auth()->user()->role->name == 'Engineer')
    {
        return true;
    }
    return false;
}

function is_Super_Admin()
{
    if(auth()->user()->role->name == 'Super Admin')
    {
        return true;
    }
    return false;
}

?>