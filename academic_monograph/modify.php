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
            $academic_monograph_monograph_title = strip_tags($_POST["academic_monograph_monograph_title"]);
            $academic_monograph_abstract = strip_tags($_POST["academic_monograph_abstract"]);
            $academic_monograph_author = strip_tags($_POST["academic_monograph_author"]);
            $academic_monograph_isbn_number = strip_tags($_POST["academic_monograph_isbn_number"]);
            $academic_monograph_country = strip_tags($_POST["academic_monograph_country"]);
            $academic_monograph_city = strip_tags($_POST["academic_monograph_city"]);
            $academic_monograph_total_word = strip_tags($_POST["academic_monograph_total_word"]);
            $academic_monograph_press = strip_tags($_POST["academic_monograph_press"]);
            $academic_monograph_published_date = strip_tags($_POST["academic_monograph_published_date"]);
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
                    $sql = "select academic_monograph_file from academic_monograph where academic_monograph_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['academic_monograph_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
                    $sql = "update academic_monograph set academic_monograph_monograph_title = ?, academic_monograph_abstract = ?, academic_monograph_author = ?, academic_monograph_isbn_number = ?, academic_monograph_country = ?, academic_monograph_city = ?, academic_monograph_total_word = ?, academic_monograph_press = ?, academic_monograph_published_date = ?, academic_monograph_file = ? where academic_monograph_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($academic_monograph_monograph_title,  $academic_monograph_abstract, $academic_monograph_author, $academic_monograph_isbn_number, $academic_monograph_country, $academic_monograph_city, $academic_monograph_total_word, $academic_monograph_press, $academic_monograph_published_date, $filenamekey, $_POST['id']));
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
                $sql = "update academic_monograph set academic_monograph_monograph_title = ?, academic_monograph_abstract = ?, academic_monograph_author = ?, academic_monograph_isbn_number = ?,academic_monograph_country = ?, academic_monograph_city = ?, academic_monograph_total_word = ?, academic_monograph_press = ?, academic_monograph_published_date = ? where academic_monograph_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($academic_monograph_monograph_title, $academic_monograph_abstract, $academic_monograph_author, $academic_monograph_isbn_number, $academic_monograph_country, $academic_monograph_city, $academic_monograph_total_word, $academic_monograph_press, $academic_monograph_published_date, $_POST['id']));
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
