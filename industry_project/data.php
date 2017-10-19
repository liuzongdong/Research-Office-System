<?php
    session_start();
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select ip_id, ip_title, ip_role, ip_type, ip_duration_from, ip_duration_to, ip_amount, action from industry_project where ip_user_id = ?"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION['user_id'])); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['ip_duration_from'] = $data[$key]['ip_duration_from']." ~ ".$data[$key]['ip_duration_to'];
            $data[$key]['action'] = "<a href=\"edit.php?id=".$data[$key]['ip_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Edit</button></a> <a onclick = confirmDelete(".$data[$key]['ip_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
        }
        $json = json_encode($data);
        echo $json;
    }
?>
