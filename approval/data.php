<?php
    session_start();
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select * from application, user where application.app_user_id = user.user_id AND user.programme = ? and approval = 0";
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION["programme"])); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']." ".$data[$key]['last_name'];
            $data[$key]['action'] = "<a href=\"approval.php?id=".$data[$key]['app_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Approve</button></a>";
            $data[$key]['file_src'] = "<a href=\"../applications/upload/".$data[$key]['file_src']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Download File</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
