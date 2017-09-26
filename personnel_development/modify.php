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
            $personnel_deveplopment_training_category = $_POST["personnel_deveplopment_training_category"];
            $personnel_deveplopment_training_person = $_POST["personnel_deveplopment_training_person"];
            $personnel_deveplopment_project_name = $_POST["personnel_deveplopment_project_name"];
            $personnel_deveplopment_author = $_POST["personnel_deveplopment_author"];
            $personnel_deveplopment_abstract = $_POST["personnel_deveplopment_abstract"];
            $personnel_deveplopment_start_date = $_POST["personnel_deveplopment_start_date"];
            $personnel_deveplopment_due_date = $_POST["personnel_deveplopment_due_date"];
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
                    $sql = "select personnel_deveplopment_file from personnel_deveplopment where personnel_deveplopment_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['personnel_deveplopment_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update personnel_deveplopment set personnel_deveplopment_training_category = ?, personnel_deveplopment_training_person = ?, personnel_deveplopment_project_name = ?, personnel_deveplopment_author = ?, personnel_deveplopment_abstract = ?, personnel_deveplopment_start_date = ?, personnel_deveplopment_due_date = ?, personnel_deveplopment_file = ? where personnel_deveplopment_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($personnel_deveplopment_training_category, $personnel_deveplopment_training_person, $personnel_deveplopment_project_name, $personnel_deveplopment_author, $personnel_deveplopment_abstract, $personnel_deveplopment_start_date, $personnel_deveplopment_due_date, $filenamekey, $_POST['id']));
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
                $sql = "update personnel_deveplopment set personnel_deveplopment_training_category = ?, personnel_deveplopment_training_person = ?, personnel_deveplopment_project_name = ?, personnel_deveplopment_author = ?, personnel_deveplopment_abstract = ?, personnel_deveplopment_start_date = ?, personnel_deveplopment_due_date = ? where personnel_deveplopment_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($personnel_deveplopment_training_category, $personnel_deveplopment_training_person, $personnel_deveplopment_project_name, $personnel_deveplopment_author, $personnel_deveplopment_abstract, $personnel_deveplopment_start_date, $personnel_deveplopment_due_date, $_POST['id']));
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
