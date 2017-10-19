<?php
    date_default_timezone_set('Asia/Shanghai');
    session_start();
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:/403.html' ) );
    }
    else
    {
        require("../base.php");
        $missing = array();
        foreach ($_POST as $key => $value)
        {
            if ($value == "" || ctype_space($value))
            {
                array_push($missing, $key);
            }
        }
        if (count($missing) > 0)
        {
            $response = array('status_response'  => 'empty');
            echo json_encode($response);
        }
        else
        {
            unset($missing);
            $update_date = date("Y-m-d H:i:s");
            $midterm_progress_report_form_title = strip_tags($_POST["midterm_progress_report_form_title"]);
            $mp_principal_investigator_name = strip_tags($_POST["mp_principal_investigator_name"]);
            $mp_principal_investigator_unit = strip_tags($_POST["mp_principal_investigator_name"]);
            $mp_co_investigator_name = strip_tags($_POST["mp_co_investigator_name"]);
            $mp_co_investigator_unit = strip_tags($_POST["mp_co_investigator_unit"]);
            $mp_others_name = strip_tags($_POST["mp_others_name"]);
            $mp_others_unit = strip_tags($_POST["mp_others_unit"]);
            $midterm_progress_report_form_project_starting_date = strip_tags($_POST["midterm_progress_report_form_project_starting_date"]);
            $midterm_progress_report_form_project_completion_date = strip_tags($_POST["midterm_progress_report_form_project_completion_date"]);
            $midterm_progress_report_form_duration = strip_tags($_POST["midterm_progress_report_form_duration"]);
            $upload_file = $_FILES["file"]["name"];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
            if (mime_content_type($_FILES['file']['tmp_name']) != "application/pdf")
            {
                $response = array('status_response'  => 'error');
                echo json_encode($response);
            }
            else
            {
                $folder="upload/";
                $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                $filenamekey .= "." . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                $action = "";
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "insert into midterm_report (midterm_report_user_id, midterm_progress_report_form_title, mp_principal_investigator_name, mp_principal_investigator_unit, mp_co_investigator_name, mp_co_investigator_unit, mp_others_name, mp_others_unit, midterm_progress_report_form_project_starting_date, midterm_progress_report_form_project_completion_date, midterm_progress_report_form_duration, midterm_report_file, update_date, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'],$midterm_progress_report_form_title, $mp_principal_investigator_name, $mp_principal_investigator_unit, $mp_co_investigator_name, $mp_co_investigator_unit, $mp_others_name, $mp_others_unit, $midterm_progress_report_form_project_starting_date, $midterm_progress_report_form_project_completion_date, $midterm_progress_report_form_duration, $filenamekey, $update_date, $action));
                if ($execute)
                {
                    $response = array('status_response'  => 'success');
                    echo json_encode($response);
                }
                else
                {
                    $response = array('status_response'  => 'fail');
                    echo json_encode($response);
                }
            }
        }
    }


?>
