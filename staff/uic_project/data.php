<?php
    session_start();
    $url = "index.php";
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }
    require("../../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select last_name, english_name, up_title, programme, division from uic_project, user where uic_project.up_user_id = user.user_id"; // *, select all. '?' and '?', SQL Injection // where email = ?
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array()); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']." ".$data[$key]['last_name'];
        }
        $json = json_encode($data);
    }
    echo $json;
?>
