<?php
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
            $conference_presentation_report_type = $_POST["conference_presentation_report_type"];
        	$conference_presentation_type_of_meeting = $_POST["conference_presentation_type_of_meeting"];
        	$conference_presentation_report_name = $_POST["conference_presentation_report_name"];
            $conference_presentation_author = $_POST["conference_presentation_author"];
            $conference_presentation_abstract = $_POST["conference_presentation_abstract"];
            $conference_presentation_conference_name = $_POST["conference_presentation_conference_name"];
            $conference_presentation_country = $_POST["conference_presentation_country"];
            $conference_presentation_conference_address = $_POST["conference_presentation_conference_address"];
            $conference_presentation_start_date = $_POST["conference_presentation_start_date"];
            $conference_presentation_due_date = $_POST["conference_presentation_due_date"];
            $action = "";
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
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "insert into conference_presentation (conference_presentation_author_id, conference_presentation_report_type, conference_presentation_type_of_meeting, conference_presentation_report_name, conference_presentation_author, conference_presentation_abstract, conference_presentation_conference_name, conference_presentation_country, conference_presentation_conference_address, conference_presentation_start_date, conference_presentation_due_date, conference_presentation_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $conference_presentation_report_type,  $conference_presentation_type_of_meeting, $conference_presentation_report_name, $conference_presentation_author, $conference_presentation_abstract, $conference_presentation_conference_name, $conference_presentation_country, $conference_presentation_conference_address, $conference_presentation_start_date, $conference_presentation_due_date, $filenamekey, $action));
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
    }
?>
