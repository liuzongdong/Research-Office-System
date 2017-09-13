<?php
    session_start();
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:404.html' ) );
    }
    else
    {
        require("../base.php");
        $default = "\$2y\$10\$Mo3sGNKbg25FV2rmX8oyJOoTWQ0wyXjH7umDKgm2MLwiAUdgfpahy";
        $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
    	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "update user set password = ? where user_id = ?";
    	$prepare = $dbh -> prepare($sql);
    	$execute = $prepare -> execute(array($default, $_POST['id']));
    	if ($execute)
    	{
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
    	}
    }


?>
