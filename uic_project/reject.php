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
        $sql = "update uic_project set up_status = ? where up_id = ?";
    	$prepare = $dbh -> prepare($sql);
    	$execute = $prepare -> execute(array("2", $_POST['id']));
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
