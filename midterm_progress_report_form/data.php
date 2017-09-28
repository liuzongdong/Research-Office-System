<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["teacher"]) && $_SESSION["teacher"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select midterm_report_id, midterm_progress_report_form_title, mp_principal_investigator_name, midterm_progress_report_form_project_starting_date, midterm_progress_report_form_project_completion_date, midterm_progress_report_form_duration, midterm_report_status, update_date, action from midterm_report where midterm_report_user_id = ?";
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(array($_SESSION['user_id'])); // Var is Var.
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
            $data[$key]['midterm_progress_report_form_project_starting_date'] = $data[$key]['midterm_progress_report_form_project_starting_date']. " ~ " .$data[$key]['midterm_progress_report_form_project_completion_date'];
            $data[$key]['action'] = "<a href=\"edit.php?id=".$data[$key]['midterm_report_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">Edit</button></a> <a onclick = confirmDelete(".$data[$key]['midterm_report_id'].")><button type=\"button\" class=\"btn btn-danger btn-xs\">Delete</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
