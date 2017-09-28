<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, midterm_report_id, midterm_progress_report_form_title, mp_principal_investigator_name, midterm_progress_report_form_project_starting_date, midterm_progress_report_form_project_completion_date, midterm_progress_report_form_duration, midterm_report_file, action, update_date, midterm_report_status from midterm_report, user where midterm_report_user_id = user_id";
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['midterm_report_status'] == 0)
            {
                $data[$key]['midterm_report_status'] = "<p class='hidden'>Waiting Approval</p><span id='waiting' class='glyphicon glyphicon-time' aria-hidden='false'></span>";
            }
            else if ($data[$key]['midterm_report_status'] == 1)
            {
                $data[$key]['midterm_report_status'] = "<p class='hidden'>Approved</p><span id='approved' class='glyphicon glyphicon-ok' aria-hidden='false'></span>";
            }
            else if ($data[$key]['midterm_report_status'] == 2)
            {
                $data[$key]['midterm_report_status'] = "<p class='hidden'>Rejected</p><span id='rejected' class='glyphicon glyphicon-remove' aria-hidden='false'></span>";
            }
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['midterm_progress_report_form_project_starting_date'] = $data[$key]['midterm_progress_report_form_project_starting_date']. " ~ " .$data[$key]['midterm_progress_report_form_project_completion_date'];
            $data[$key]['action'] = "<a href=\"upload/".$data[$key]['midterm_report_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a> <a href=\"view.php?id=".$data[$key]['midterm_report_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a onclick = confirmApprove(".$data[$key]['midterm_report_id'].")><button type=\"button\" class=\"btn btn-primary btn-xs\">Approve</button></a> <a onclick = confirmReject(".$data[$key]['midterm_report_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Reject</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
