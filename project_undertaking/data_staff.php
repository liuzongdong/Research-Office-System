<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, project_undertaking_id, project_undertaking_type, project_undertaking_title, project_undertaking_file, update_date, project_undertaking_status, action from project_undertaking, user where project_undertaking_user_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['project_undertaking_status'] == 0)
            {
                $data[$key]['project_undertaking_status'] = "<p class='hidden'>Waiting Approval</p><span id='waiting' class='glyphicon glyphicon-time' aria-hidden='false'></span>";
            }
            else if ($data[$key]['project_undertaking_status'] == 1)
            {
                $data[$key]['project_undertaking_status'] = "<p class='hidden'>Approved</p><span id='approved' class='glyphicon glyphicon-ok' aria-hidden='false'></span>";
            }
            else if ($data[$key]['project_undertaking_status'] == 2)
            {
                $data[$key]['project_undertaking_status'] = "<p class='hidden'>Rejected</p><span id='rejected' class='glyphicon glyphicon-remove' aria-hidden='false'></span>";
            }
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            // $data[$key]['up_duration_from'] = $data[$key]['up_duration_from']. " ~ " .$data[$key]['up_duration_to'];
            $data[$key]['action'] = "<a href=\"view.php?id=".$data[$key]['project_undertaking_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"upload/".$data[$key]['project_undertaking_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
