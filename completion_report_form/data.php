<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select completion_report_id, completion_report_form_title, cr_principal_investigator_name, completion_report_form_project_starting_date, completion_report_form_project_completion_date, actual_project_starting_date, actual_project_completion_date, completion_report_status, update_date, action from completion_report where completion_report_user_id = ?"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION['user_id'])); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            if ($data[$key]['completion_report_status'] == 0)
            {
                $data[$key]['completion_report_status'] = "<p class='hidden'>Waiting Approval</p><span id='waiting' class='glyphicon glyphicon-time' aria-hidden='false'></span>";
            }
            else if ($data[$key]['completion_report_status'] == 1)
            {
                $data[$key]['completion_report_status'] = "<p class='hidden'>Approved</p><span id='approved' class='glyphicon glyphicon-ok' aria-hidden='false'></span>";
            }
            else if ($data[$key]['completion_report_status'] == 2)
            {
                $data[$key]['completion_report_status'] = "<p class='hidden'>Rejected</p><span id='rejected' class='glyphicon glyphicon-remove' aria-hidden='false'></span>";
            }
            $data[$key]['completion_report_form_project_starting_date'] = $data[$key]['completion_report_form_project_starting_date']. " ~ " .$data[$key]['completion_report_form_project_completion_date'];
            $data[$key]['actual_project_starting_date'] = $data[$key]['actual_project_starting_date']. " ~ " .$data[$key]['actual_project_completion_date'];
            $data[$key]['action'] = "<a href=\"edit.php?id=".$data[$key]['completion_report_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Edit</button></a> <a onclick = confirmDelete(".$data[$key]['completion_report_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
