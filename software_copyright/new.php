<?php
    session_start();
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
    } //Deny directly access from url, which means, user cannot type "mysiteaddress/new.php" in the address bar.
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
            $software_copyright_dynacomm = $_POST["software_copyright_dynacomm"];
        	$software_copyright_author = $_POST["software_copyright_author"];
        	$software_copyright_registration_number = $_POST["software_copyright_registration_number"];
            $software_copyright_completion_time = $_POST["software_copyright_completion_time"];
            $software_copyright_way = $_POST["software_copyright_way"];
            $software_copyright_scope = $_POST["software_copyright_scope"];
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
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
                $sql = "insert into software_copyright (software_copyright_author_id, software_copyright_dynacomm, software_copyright_author, software_copyright_registration_number, software_copyright_completion_time, software_copyright_way, software_copyright_scope, software_copyright_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $software_copyright_dynacomm, $software_copyright_author,  $software_copyright_registration_number, $software_copyright_completion_time, $software_copyright_way, $software_copyright_scope, $filenamekey, $action));
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
