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
        $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "select project_undertaking_user_id, project_undertaking_file from project_undertaking where project_undertaking_id = ?";
    	$prepare = $dbh -> prepare($sql);
    	$execute = $prepare -> execute(array($_POST['id']));
    	if ($execute)
    	{
    		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
    		if ($data['project_undertaking_user_id'] != $_SESSION['user_id'])
    		{
                $response = array('status_response'  => 'error');
                echo json_encode($response);
    		}
            else
            {
                $sql = "delete from project_undertaking where project_undertaking_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_POST['id']));
                if ($execute)
                {
                    unlink("upload/".$data['project_undertaking_file']);
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
