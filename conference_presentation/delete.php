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
        $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	    $sql = "select conference_presentation_author_id, conference_presentation_file from conference_presentation where conference_presentation_id = ?";
	    $prepare = $dbh -> prepare($sql); // Statement is Statement.
        $execute = $prepare -> execute(array($_POST['id']));
        if ($execute)
        {
            $data = $prepare -> fetch(PDO::FETCH_ASSOC);
            if ($data['conference_presentation_author_id'] != $_SESSION['user_id'])
            {
                $response = array('status_response'  => 'error');
                echo json_encode($response);
            }
            else
            {
                unlink("upload/".$data['conference_presentation_file']);
                $sql = "delete from conference_presentation where conference_presentation_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_POST['id']));
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
