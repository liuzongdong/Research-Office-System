<?php
    session_start();
    $url = "index.php";
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }
    session_unset();
    session_destroy();
    header("Location: index.php");
?>
