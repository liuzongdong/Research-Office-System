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
            $title = strip_tags($_POST["report_name"]);
            $abstract = strip_tags($_POST["abstract"]);
            $author = strip_tags($_POST["author"]);
            $type = strip_tags($_POST["report_type"]);
            $conference_name = strip_tags($_POST["conference_name"]);
        	$conference_addressorganizer = strip_tags($_POST["conference_addressorganizer"]);
            $country = strip_tags($_POST["country"]);
            $city = strip_tags($_POST["city"]);
            $conference_address = strip_tags($_POST["conference_address"]);
            $page_number = strip_tags($_POST["page_number"]);
            $start_date = strip_tags($_POST["start_date"]);
            $due_date = strip_tags($_POST["due_date"]);
            $published_date = strip_tags($_POST["published_date"]);
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
                $sql = "insert into conference_paper (conference_paper_user_id, report_name, conference_paper_abstract, conference_paper_authors, report_type, conference_paper_name, conference_paper_organizer, region, city, address, page_number, start_date, due_date, published_date, conference_paper_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $title, $abstract, $author, $type, $conference_name, $conference_addressorganizer, $country, $city, $conference_address, $page_number, $start_date, $due_date, $published_date, $filenamekey, $action));
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
