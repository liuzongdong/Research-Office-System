<?php
    session_start();
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
    }
    else
    {
        require("../base.php");
        $missing = array();
        foreach ($_POST as $key => $value)
        {
            if ($value == "")
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
                    $sql = "select journal_src from journal where journal_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['journal_src']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update journal set journal_title = ?, journal_abstract = ?, journal_authors = ?, journal_name = ?, journal_date = ?, journal_status = ?, sci = ?, ei = ?, istp = ?, iff = ?, acknowledged = ?, journal_src = ? where journal_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($title, $abstract, $author, $journalname, $time, $published_status, $sci, $ei, $istp, $if, $acknowledged, $filenamekey, $_POST['id']));
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
                $sql = "update journal set journal_title = ?, journal_abstract = ?, journal_authors = ?, journal_name = ?, journal_date = ?, journal_status = ?, sci = ?, ei = ?, istp = ?, iff = ?, acknowledged = ? where journal_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($title, $abstract, $author, $journalname, $time, $published_status, $sci, $ei, $istp, $if, $acknowledged, $_POST['id']));
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
