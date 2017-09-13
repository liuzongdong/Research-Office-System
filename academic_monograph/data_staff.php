<?php
    session_start();
    require("../base.php");
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
        header("Location:".$url); exit;
    }
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, academic_monograph_id, academic_monograph_monograph_title, academic_monograph_author, academic_monograph_press, academic_monograph_published_date, academic_monograph_isbn_number, academic_monograph_file, action from academic_monograph, user where academic_monograph_author_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['action'] = "<a href=\"view.php?id=".$data[$key]['academic_monograph_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"upload/".$data[$key]['academic_monograph_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
