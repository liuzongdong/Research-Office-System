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
            $research_award_achievement_name = $_POST["research_award_achievement_name"];
            $research_award_abstract = $_POST["research_award_abstract"];
            $research_award_author = $_POST["research_award_author"];
            $research_award_assessment_organization = $_POST["research_award_assessment_organization"];
            $research_award_publication_time = $_POST["research_award_publication_time"];
            $research_award_reward_category = $_POST["research_award_reward_category"];
            $research_award_reward_grade = $_POST["research_award_reward_grade"];
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
                $dbh = new PDO($dbinfo, $dbusername, $dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "insert into research_award (research_award_author_id, research_award_achievement_name, research_award_abstract, research_award_author, research_award_assessment_organization, research_award_publication_time, research_award_reward_category, research_award_reward_grade, research_award_file, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION['user_id'], $research_award_achievement_name, $research_award_abstract, $research_award_author, $research_award_assessment_organization, $research_award_publication_time, $research_award_reward_category, $research_award_reward_grade, $filenamekey, $action));
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
