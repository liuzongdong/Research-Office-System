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
            $research_award_achievement_name = strip_tags($_POST["research_award_achievement_name"]);
            $research_award_abstract = strip_tags($_POST["research_award_abstract"]);
            $research_award_author = strip_tags($_POST["research_award_author"]);
            $research_award_assessment_organization = strip_tags($_POST["research_award_assessment_organization"]);
            $research_award_publication_time = strip_tags($_POST["research_award_publication_time"]);
            $research_award_reward_category = strip_tags($_POST["research_award_reward_category"]);
            $research_award_reward_grade = strip_tags($_POST["research_award_reward_grade"]);
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
                    $sql = "select research_award_file from research_award where research_award_id = ?";
                	$prepare = $dbh -> prepare($sql);
                	$execute = $prepare -> execute(array($_POST['id']));
                	if ($execute)
                	{
                		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
                		unlink("upload/".$data['research_award_file']);
                	}
                    $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
                    $folder="upload/";
                    $filenamekey = md5(uniqid($_FILES["file"]["name"], true));
                    $filenamekey .= "." . $extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], "$folder".$filenamekey);
                    $sql = "update research_award set research_award_achievement_name = ?, research_award_abstract = ?, research_award_author = ?, research_award_assessment_organization = ?, research_award_publication_time = ?, research_award_reward_category = ?, research_award_reward_grade = ?, research_award_file = ? where research_award_id = ?";
                    $prepare = $dbh -> prepare($sql);
                    $execute = $prepare -> execute(array($research_award_achievement_name, $research_award_abstract, $research_award_author, $research_award_assessment_organization, $research_award_publication_time, $research_award_reward_category, $research_award_reward_grade, $filenamekey, $_POST['id']));
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
                $dbh = new PDO($dbinfo, $dbusername, $dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "update research_award set research_award_achievement_name = ?, research_award_abstract = ?, research_award_author = ?, research_award_assessment_organization = ?, research_award_publication_time = ?, research_award_reward_category = ?, research_award_reward_grade = ? where research_award_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($research_award_achievement_name, $research_award_abstract, $research_award_author, $research_award_assessment_organization, $research_award_publication_time, $research_award_reward_category, $research_award_reward_grade, $_POST['id']));
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
