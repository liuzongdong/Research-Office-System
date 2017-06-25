<?php
    session_start();
    require("../../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select last_name, english_name, app_title, app_type, programme, division, app_update_date, action, file_src from application, user where application.app_user_id = user.user_id AND application.app_type = \"Publication On Fund\" AND application.approval = 1"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array()); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall();
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']." ".$data[$key]['last_name'];
            $data[$key]['action'] = "<a href=\"../../applications/upload/".$data[$key]['file_src']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Download File</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
