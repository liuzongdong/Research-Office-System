<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../../login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, iv_project_id, update_date, iv_project_name, iv_project_budget, iv_project_status, iv_project_file, action from iv_project, user where iv_project_user_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
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
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['action'] = "<a href=\"upload/".$data[$key]['iv_project_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a> <a href=\"view.php?id=".$data[$key]['iv_project_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a onclick = confirmApprove(".$data[$key]['iv_project_id'].")><button type=\"button\" class=\"btn btn-primary btn-xs\">Approve</button></a> <a onclick = confirmReject(".$data[$key]['iv_project_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Reject</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
