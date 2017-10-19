<?php
    error_reporting(0);
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
            $firstname = strip_tags($_POST["firstname"]);
            $lastname = strip_tags($_POST["lastname"]);
            $englishname = strip_tags($_POST["englishname"]);
            $degree = strip_tags($_POST["degree"]);
            $phone = strip_tags($_POST["phone"]);
            $education = strip_tags($_POST["education"]);
            $division = strip_tags($_POST["division"]);
            $programme = strip_tags($_POST["programme"]);
            $upload_file=$_FILES["avator"]["name"];
            if ($upload_file != "")
            {
                if (exif_imagetype($_FILES['avator']['tmp_name']))
                {
                    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    $sql = "select image_src from user where user_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($_SESSION["user_id"]));
                    if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                        unlink("upload/".$data['image_src']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["avator"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["avator"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update user set last_name = ?, first_name = ?, english_name = ?, degree = ?, phone = ?, education_desc = ?, division = ?, programme = ?, image_src = ? where user_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($lastname, $firstname, $englishname, $degree, $phone, $education, $division, $programme, $filenamekey, $_SESSION["user_id"]));
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
                else
                {
                    $response = array('status_response'  => 'error');
                    echo json_encode($response);
                }
            }
            else
            {
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
                $sql = "update user set last_name = ?, first_name = ?, english_name = ?, degree = ?, phone = ?, education_desc = ?, division = ?, programme = ? where user_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($lastname, $firstname, $englishname, $degree, $phone, $education, $division, $programme, $_SESSION["user_id"]));
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
