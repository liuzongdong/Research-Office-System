<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, midterm_report_id, midterm_progress_report_form_title, mp_principal_investigator_name, midterm_progress_report_form_project_starting_date, midterm_progress_report_form_project_completion_date, midterm_progress_report_form_duration, midterm_report_file, action from midterm_report, user where midterm_report_user_id = user_id";
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['midterm_progress_report_form_project_starting_date'] = $data[$key]['midterm_progress_report_form_project_starting_date']. " ~ " .$data[$key]['midterm_progress_report_form_project_completion_date'];
            $data[$key]['action'] = "<a href=\"view.php?id=".$data[$key]['midterm_report_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"upload/".$data[$key]['midterm_report_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
