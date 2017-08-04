<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, iv_project_id, iv_project_name, iv_project_budget, iv_project_file, action from iv_project, user where iv_project_user_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            // $data[$key]['up_duration_from'] = $data[$key]['up_duration_from']. " ~ " .$data[$key]['up_duration_to'];
            $data[$key]['action'] = "<a href=\"view.php?id=".$data[$key]['iv_project_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"upload/".$data[$key]['iv_project_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
