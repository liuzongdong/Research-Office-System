<?php
    session_start();
    require("../base.php");
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:/403.html' ) );
    }
    else
    {
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
            $midterm_progress_report_form_title = $_POST["midterm_progress_report_form_title"];
            $mp_principal_investigator_name = $_POST["mp_principal_investigator_name"];
            $mp_principal_investigator_unit = $_POST["mp_principal_investigator_name"];
            $mp_co_investigator_name = $_POST["mp_co_investigator_name"];
            $mp_co_investigator_unit = $_POST["mp_co_investigator_unit"];
            $mp_others_name = $_POST["mp_others_name"];
            $mp_others_unit = $_POST["mp_others_unit"];
            $midterm_progress_report_form_project_starting_date = $_POST["midterm_progress_report_form_project_starting_date"];
            $midterm_progress_report_form_project_completion_date = $_POST["midterm_progress_report_form_project_completion_date"];
            $midterm_progress_report_form_duration = $_POST["midterm_progress_report_form_duration"];
            $upload_file = $_FILES["file"]["name"];
            if ($upload_file != "")
            {

                if (mime_content_type($_FILES['file']['tmp_name']) != "application/pdf")
                {
                    $response = array('status_response'  => 'error');
                    echo json_encode($response);
                }
                else
                {
                    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    $sql = "select midterm_report_file from midterm_report where midterm_report_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                        unlink("upload/".$data['midterm_report_file']);
                    }
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update midterm_report set midterm_progress_report_form_title = ?, mp_principal_investigator_name = ?, mp_principal_investigator_unit = ?,  mp_co_investigator_name = ?, mp_co_investigator_unit = ?, mp_others_name = ?, mp_others_unit = ?, midterm_progress_report_form_project_starting_date = ?, midterm_progress_report_form_project_completion_date = ?, midterm_progress_report_form_duration = ?, midterm_report_file = ? where midterm_report_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($midterm_progress_report_form_title, $mp_principal_investigator_name, $mp_principal_investigator_unit,  $mp_co_investigator_name, $mp_co_investigator_unit, $mp_others_name, $mp_others_unit, $midterm_progress_report_form_project_starting_date, $midterm_progress_report_form_project_completion_date, $midterm_progress_report_form_duration, $filenamekey, $_POST['id']));
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
                    $dbh = null;
                }
            }
            else
            {
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
                $sql = "update midterm_report set midterm_progress_report_form_title = ?, mp_principal_investigator_name = ?, mp_principal_investigator_unit = ?,  mp_co_investigator_name = ?, mp_co_investigator_unit = ?, mp_others_name = ?, mp_others_unit = ?, midterm_progress_report_form_project_starting_date = ?, midterm_progress_report_form_project_completion_date = ?, midterm_progress_report_form_duration = ? where midterm_report_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($midterm_progress_report_form_title, $mp_principal_investigator_name, $mp_principal_investigator_unit,  $mp_co_investigator_name, $mp_co_investigator_unit, $mp_others_name, $mp_others_unit, $midterm_progress_report_form_project_starting_date, $midterm_progress_report_form_project_completion_date, $midterm_progress_report_form_duration, $_POST['id']));
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
