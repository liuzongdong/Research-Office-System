<?php
    session_start();
    require("../base.php");
    $url = "index.php";
    // if( $_SERVER['HTTP_REFERER'] == "" )
    // {
    //     header("Location:".$url); exit;
    // }
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select iv_project_id, iv_project_name, update_date, iv_project_status, iv_project_budget, action from iv_project where iv_project_user_id = ?"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION['user_id'])); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['iv_project_status'] == 0)
            {
                $data[$key]['iv_project_status'] = "<p class='hidden'>Waiting Approval</p><span id='waiting' class='glyphicon glyphicon-time' aria-hidden='false'></span>";
            }
            else if ($data[$key]['iv_project_status'] == 1)
            {
                $data[$key]['iv_project_status'] = "<p class='hidden'>Approved</p><span id='approved' class='glyphicon glyphicon-ok' aria-hidden='false'></span>";
            }
            else if ($data[$key]['iv_project_status'] == 2)
            {
                $data[$key]['iv_project_status'] = "<p class='hidden'>Rejected</p><span id='rejected' class='glyphicon glyphicon-remove' aria-hidden='false'></span>";
            }
            // $data[$key]['up_duration_from'] = $data[$key]['up_duration_from']. " ~ " .$data[$key]['up_duration_to'];
            $data[$key]['action'] = "<a href=\"edit.php?id=".$data[$key]['iv_project_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Edit</button></a> <a onclick = confirmDelete(".$data[$key]['iv_project_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
