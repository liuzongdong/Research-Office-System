<?php
    session_start();
    require("../base.php");
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
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
            $title = $_POST["title"];
            $type = $_POST["type"];
        	$role = $_POST["role"];
            $source = $_POST["source"];
            $duration_from = $_POST["from"];
            $duration_to = $_POST["to"];
        	$amount = $_POST["amount"];
            $action = "";
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
                    $sql = "select ip_file from industry_project where ip_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['ip_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update industry_project set ip_title = ?, ip_type = ?, ip_role = ?, ip_fundsource = ?, ip_duration_from = ?, ip_duration_to = ?, ip_amount = ?, ip_file = ? where ip_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($title, $type, $role, $source, $duration_from, $duration_to, $amount, $filenamekey, $_POST["id"]));
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
                $sql = "update industry_project set ip_title = ?, ip_type = ?, ip_role = ?, ip_fundsource = ?, ip_duration_from = ?, ip_duration_to = ?, ip_amount = ? where ip_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($title, $type, $role, $source, $duration_from, $duration_to, $amount, $_POST["id"]));
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
