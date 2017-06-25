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
            $academic_monograph_monograph_title = $_POST["academic_monograph_monograph_title"];
        	$academic_monograph_abstract = $_POST["academic_monograph_abstract"];
        	$academic_monograph_author = $_POST["academic_monograph_author"];
            $academic_monograph_isbn_number = $_POST["academic_monograph_isbn_number"];
            $academic_monograph_country = $_POST["academic_monograph_country"];
            $academic_monograph_city = $_POST["academic_monograph_city"];
            $academic_monograph_total_word = $_POST["academic_monograph_total_word"];
            $academic_monograph_press = $_POST["academic_monograph_press"];
            $academic_monograph_published_date = $_POST["academic_monograph_published_date"];
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
                $sql = "insert into academic_monograph (academic_monograph_author_id, academic_monograph_monograph_title, academic_monograph_abstract, academic_monograph_author, academic_monograph_isbn_number, academic_monograph_country, academic_monograph_city, academic_monograph_total_word, academic_monograph_press, academic_monograph_published_date, academic_monograph_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $academic_monograph_monograph_title, $academic_monograph_abstract, $academic_monograph_author, $academic_monograph_isbn_number, $academic_monograph_country, $academic_monograph_city, $academic_monograph_total_word, $academic_monograph_press, $academic_monograph_published_date, $filenamekey, $action));
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
