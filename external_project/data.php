<?php
    session_start();
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select ep_id, ep_title, ep_role, ep_duration_from, ep_duration_to, ep_amount, ep_type, action from external_project where ep_user_id = ?"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION['user_id'])); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['ep_duration_from'] = $data[$key]['ep_duration_from']." ~ ".$data[$key]['ep_duration_to'];
            $data[$key]['action'] = "<a href=\"edit?id=".$data[$key]['ep_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Edit</button></a> <a onclick = confirmDelete(".$data[$key]['ep_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
        }
        $json = json_encode($data);
        echo $json;
    }
?>
