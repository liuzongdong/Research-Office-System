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
            if ($value == "")
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
            $conference_presentation_report_type = strip_tags($_POST["conference_presentation_report_type"]);
            $conference_presentation_type_of_meeting = strip_tags($_POST["conference_presentation_type_of_meeting"]);
            $conference_presentation_report_name = strip_tags($_POST["conference_presentation_report_name"]);
            $conference_presentation_author = strip_tags($_POST["conference_presentation_author"]);
            $conference_presentation_abstract = strip_tags($_POST["conference_presentation_abstract"]);
            $conference_presentation_conference_name = strip_tags($_POST["conference_presentation_conference_name"]);
            $conference_presentation_country = strip_tags($_POST["conference_presentation_country"]);
            $conference_presentation_conference_address = strip_tags($_POST["conference_presentation_conference_address"]);
            $conference_presentation_start_date = strip_tags($_POST["conference_presentation_start_date"]);
            $conference_presentation_due_date = strip_tags($_POST["conference_presentation_due_date"]);
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
                    $sql = "select conference_presentation_file from conference_presentation where conference_presentation_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['conference_presentation_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update conference_presentation set conference_presentation_report_type = ?, conference_presentation_type_of_meeting = ? , conference_presentation_report_name = ? , conference_presentation_author = ? , conference_presentation_abstract = ? , conference_presentation_conference_name = ? , conference_presentation_country = ? , conference_presentation_conference_address = ?, conference_presentation_start_date = ?, conference_presentation_due_date = ?, conference_presentation_file = ? where conference_presentation_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($conference_presentation_report_type,  $conference_presentation_type_of_meeting, $conference_presentation_report_name, $conference_presentation_author, $conference_presentation_abstract, $conference_presentation_conference_name, $conference_presentation_country, $conference_presentation_conference_address, $conference_presentation_start_date, $conference_presentation_due_date, $filenamekey, $_POST['id']));
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
                $sql = "update conference_presentation set conference_presentation_report_type = ?, conference_presentation_type_of_meeting = ? , conference_presentation_report_name = ? , conference_presentation_author = ? , conference_presentation_abstract = ? , conference_presentation_conference_name = ? , conference_presentation_country = ? , conference_presentation_conference_address = ?, conference_presentation_start_date = ?, conference_presentation_due_date = ? where conference_presentation_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($conference_presentation_report_type,  $conference_presentation_type_of_meeting, $conference_presentation_report_name, $conference_presentation_author, $conference_presentation_abstract, $conference_presentation_conference_name, $conference_presentation_country, $conference_presentation_conference_address, $conference_presentation_start_date, $conference_presentation_due_date, $_POST['id']));
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
