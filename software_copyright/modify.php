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
            $software_copyright_dynacomm = $_POST["software_copyright_dynacomm"];
            $software_copyright_author = $_POST["software_copyright_author"];
            $software_copyright_registration_number = $_POST["software_copyright_registration_number"];
            $software_copyright_completion_time = $_POST["software_copyright_completion_time"];
            $software_copyright_way = $_POST["software_copyright_way"];
            $software_copyright_scope = $_POST["software_copyright_scope"];
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
                    $sql = "select software_copyright_file from software_copyright where software_copyright_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['software_copyright_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update software_copyright set software_copyright_dynacomm = ?, software_copyright_author = ?, software_copyright_registration_number = ?, software_copyright_completion_time = ?, software_copyright_way = ?, software_copyright_scope = ?, software_copyright_file = ? where software_copyright_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($software_copyright_dynacomm, $software_copyright_author, $software_copyright_registration_number, $software_copyright_completion_time, $software_copyright_way, $software_copyright_scope, $filenamekey, $_POST['id']));
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
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "update software_copyright set software_copyright_dynacomm = ?, software_copyright_author = ?, software_copyright_registration_number = ?, software_copyright_completion_time = ?, software_copyright_way = ?, software_copyright_scope = ? where software_copyright_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($software_copyright_dynacomm, $software_copyright_author, $software_copyright_registration_number, $software_copyright_completion_time, $software_copyright_way, $software_copyright_scope, $_POST['id']));
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
