<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="../login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, up_id, up_title, update_date, up_duration_from, up_duration_to, up_file, up_status, action from uic_project, user where uic_project.up_user_id = user.user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql);
    $execute = $prepare -> execute();
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['up_status'] == 0)
            {
                $data[$key]['up_status'] = "<p class='hidden'>Waiting Approval</p><span id='waiting' class='glyphicon glyphicon-time' aria-hidden='false'></span>";
            }
            else if ($data[$key]['up_status'] == 1)
            {
                $data[$key]['up_status'] = "<p class='hidden'>Approved</p><span id='approved' class='glyphicon glyphicon-ok' aria-hidden='false'></span>";
            }
            else if ($data[$key]['up_status'] == 2)
            {
                $data[$key]['up_status'] = "<p class='hidden'>Rejected</p><span id='rejected' class='glyphicon glyphicon-remove' aria-hidden='false'></span>";
            }
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['up_duration_from'] = $data[$key]['up_duration_from']. " ~ " .$data[$key]['up_duration_to'];
            $data[$key]['action'] = "<a href=\"upload/".$data[$key]['up_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a> <a href=\"view.php?id=".$data[$key]['up_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a onclick = confirmApprove(".$data[$key]['up_id'].")><button type=\"button\" class=\"btn btn-primary btn-xs\">Approve</button></a> <a onclick = confirmReject(".$data[$key]['up_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Reject</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
