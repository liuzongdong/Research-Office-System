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
        $sql = "update iv_project set iv_project_status = ? where iv_project_id = ?";
    	$prepare = $dbh -> prepare($sql);
    	$execute = $prepare -> execute(array("1", $_POST['id']));
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


?>
