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
            $name = $_POST["name"];
        	$code = $_POST["code"];
        	$authorization = $_POST["authorization"];
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
                    $sql = "select patent_src from patent where patent_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                        $data = $prepare -> fetch(PDO::FETCH_ASSOC);
                        unlink("upload/".$data['patent_src']);
                    }
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update patent set patent_name = ?, patent_code = ?, patent_authorization = ?, patent_src = ? where patent_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($name, $code, $authorization, $filenamekey, $_POST['id']));
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
                $sql = "update patent set patent_name = ?, patent_code = ?, patent_authorization = ? where patent_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($name, $code, $authorization, $_POST['id']));
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
