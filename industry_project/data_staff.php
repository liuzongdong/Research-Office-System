<?php
    session_start();
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, ip_id, ip_title, ip_role, ip_type, ip_duration_from, ip_duration_to, ip_amount, action from industry_project, user where ip_user_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['ip_duration_from'] = $data[$key]['ip_duration_from']." ~ ".$data[$key]['ip_duration_to'];
            $data[$key]['action'] = "<a href=\"view?id=".$data[$key]['ip_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"view?id=".$data[$key]['ip_id']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
        echo $json;
    }
?>
