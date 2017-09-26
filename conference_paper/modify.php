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
            $title = $_POST["report_name"];
            $abstract = $_POST["abstract"];
            $author = $_POST["author"];
            $type = $_POST["report_type"];
            $conference_name = $_POST["conference_name"];
        	$conference_addressorganizer = $_POST["conference_addressorganizer"];
            $country = $_POST["country"];
            $city = $_POST["city"];
            $conference_address = $_POST["conference_address"];
            $page_number = $_POST["page_number"];
            $start_date = $_POST["start_date"];
            $due_date = $_POST["due_date"];
            $published_date = $_POST["published_date"];
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
                    $sql = "select conference_paper_file from conference_paper where conference_paper_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['conference_paper_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update conference_paper set report_name = ?, conference_paper_abstract = ?, conference_paper_authors = ?, report_type = ?, conference_paper_name = ?, conference_paper_organizer = ?, region = ?, city = ?, address = ?, page_number = ?, start_date = ?, due_date = ?, published_date = ?, conference_paper_file = ? where conference_paper_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($title, $abstract, $author, $type, $conference_name, $conference_addressorganizer, $country, $city, $conference_address, $page_number, $start_date, $due_date, $published_date, $filenamekey, $_POST['id']));
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
                $sql = "update conference_paper set report_name = ?, conference_paper_abstract = ?, conference_paper_authors = ?, report_type = ?, conference_paper_name = ?, conference_paper_organizer = ?, region = ?, city = ?, address = ?, page_number = ?, start_date = ?, due_date = ?, published_date = ? where conference_paper_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($title, $abstract, $author, $type, $conference_name, $conference_addressorganizer, $country, $city, $conference_address, $page_number, $start_date, $due_date, $published_date, $_POST['id']));
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
