<?php
    session_start();
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
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
            $midtern_progress_report_form_title = $_POST["midtern_progress_report_form_title"];
            $mp_principal_investigator_name = $_POST["mp_principal_investigator_name"];
            $mp_principal_investigator_unit = $_POST["mp_principal_investigator_name"];
            $mp_co_investigator_name = $_POST["mp_co_investigator_name"];
            $mp_co_investigator_unit = $_POST["mp_co_investigator_unit"];
            $mp_others_name = $_POST["mp_others_name"];
            $mp_others_unit = $_POST["mp_others_unit"];
            $midtern_progress_report_form_project_starting_date = $_POST["midtern_progress_report_form_project_starting_date"];
            $midtern_progress_report_form_project_completion_date = $_POST["midtern_progress_report_form_project_completion_date"];
            $midtern_progress_report_form_duration = $_POST["midtern_progress_report_form_duration"];
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
                $sql = "insert into uic_project (up_user_id, midtern_progress_report_form_title, mp_principal_investigator_name, mp_principal_investigator_unit,  mp_co_investigator_name, mp_co_investigator_unit, mp_others_name, mp_others_unit, midtern_progress_report_form_project_starting_date, midtern_progress_report_form_project_completion_date, midtern_progress_report_form_duration, action
) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'],$midtern_progress_report_form_title, $mp_principal_investigator_name, $mp_principal_investigator_unit,  $mp_co_investigator_name, $mp_co_investigator_unit, $mp_others_name, $mp_others_unit, $midtern_progress_report_form_project_starting_date, $midtern_progress_report_form_project_completion_date, $midtern_progress_report_form_duration, $action
));
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
