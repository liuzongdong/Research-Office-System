<?php
    session_start();
    require("../base.php");
    if (!(isset($_SESSION["staff"]) && $_SESSION["staff"] === true))
	{
		echo '<script type="text/javascript">alert("Please Login");location.href="/login.html"</script>';
	}
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "select division, programme, english_name, last_name, completion_report_id, completion_report_form_title, cr_principal_investigator_name, completion_report_form_project_starting_date, completion_report_form_project_completion_date, actual_project_starting_date, actual_project_completion_date, completion_report_file, action from completion_report, user where completion_report_user_id = user_id"; // *, select all. '?' and '?', SQL Injection
    $prepare = $dbh -> prepare($sql); // Statement is Statement.
    $execute = $prepare -> execute(); // Var is Var.
    if ($execute)
    {
        $data = $prepare -> fetchall(PDO::FETCH_ASSOC);
        foreach($data as $key => $value)
        {
            $data[$key]['english_name'] = $data[$key]['english_name']. " " .$data[$key]['last_name'];
            $data[$key]['completion_report_form_project_starting_date'] = $data[$key]['completion_report_form_project_starting_date']. " ~ " .$data[$key]['completion_report_form_project_completion_date'];
            $data[$key]['actual_project_starting_date'] = $data[$key]['actual_project_starting_date']. " ~ " .$data[$key]['actual_project_completion_date'];
            $data[$key]['action'] = "<a href=\"view.php?id=".$data[$key]['completion_report_id']."\"><button type=\"button\" class=\"btn btn-primary btn-xs\">View</button></a> <a href=\"upload/".$data[$key]['completion_report_file']."\"><button type=\"button\" class=\"btn btn-default btn-xs\">Download</button></a>";
        }
        $json = json_encode($data);
    }
    echo $json;
?>
