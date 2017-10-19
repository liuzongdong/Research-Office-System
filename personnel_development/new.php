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
            $personnel_deveplopment_training_category = strip_tags($_POST["personnel_deveplopment_training_category"]);
        	$personnel_deveplopment_training_person = strip_tags($_POST["personnel_deveplopment_training_person"]);
        	$personnel_deveplopment_project_name = strip_tags($_POST["personnel_deveplopment_project_name"]);
            $personnel_deveplopment_author = strip_tags($_POST["personnel_deveplopment_author"]);
            $personnel_deveplopment_abstract = strip_tags($_POST["personnel_deveplopment_abstract"]);
            $personnel_deveplopment_start_date = strip_tags($_POST["personnel_deveplopment_start_date"]);
            $personnel_deveplopment_due_date = strip_tags($_POST["personnel_deveplopment_due_date"]);
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
                $dbh = new PDO($dbinfo, $dbusername, $dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "insert into personnel_deveplopment (personnel_deveplopment_author_id, personnel_deveplopment_training_category, personnel_deveplopment_training_person, personnel_deveplopment_project_name, personnel_deveplopment_author, personnel_deveplopment_abstract, personnel_deveplopment_start_date, personnel_deveplopment_due_date, personnel_deveplopment_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $personnel_deveplopment_training_category, $personnel_deveplopment_training_person,  $personnel_deveplopment_project_name, $personnel_deveplopment_author, $personnel_deveplopment_abstract, $personnel_deveplopment_start_date, $personnel_deveplopment_due_date, $filenamekey, $action));
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
