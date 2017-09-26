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
            $title = $_POST["title"];
            $abstract = $_POST["abstract"];
            $author = $_POST["author"];
            $journalname = $_POST["journalname"];
            $time = $_POST["time"];
        	$published_status = $_POST["published_status"];
            $sci = $_POST["sci"];
            $ei = $_POST["ei"];
            $istp = $_POST["istp"];
            $if = $_POST["if"];
            $acknowledged = $_POST["acknowledged"];
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
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "insert into journal (journal_user_id, journal_title, journal_abstract, journal_authors, journal_name, journal_date, journal_status, sci, ei, istp, iff, acknowledged, journal_src, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $title, $abstract, $author, $journalname, $time, $published_status, $sci, $ei, $istp, $if, $acknowledged, $filenamekey, $action));
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
