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
            $title = strip_tags($_POST["title"]);
            $updateddate = date("Y  M  d");
            $type = "Visiting Scholar";
            if ($_SESSION['user_type'] == 2)
            {
                $approval = 1;
            }
            else
            {
                $approval = 0;
            }
            if (mime_content_type($_FILES['file']['tmp_name']) != "application/pdf")
            {
                $response = array('status_response'  => 'error');
                echo json_encode($response);
            }
            else
            {
                $upload_file=$_FILES["file"]["name"];
                $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                $folder="upload/";
                $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                $filenamekey .= "." . $extension;
                move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                $action = "";
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
                $sql = "insert into application (app_user_id, app_title, app_update_date, action, app_type, file_src, approval) values(?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $title, $updateddate, $action, $type, $filenamekey, $approval));
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
