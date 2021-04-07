<?php
session_start();
$db = mysqli_connect('localhost','root','','wpoettest');

if(mysqli_connect_errno())
{
    echo 'failed connnection'.mysqli_connect_error() ;
    die();
}

?>