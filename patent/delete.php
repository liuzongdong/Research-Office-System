<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
    }
    session_start();
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$sql = "select patent_author_id, patent_src from patent where patent_id = ?";
	$prepare = $dbh -> prepare($sql);
	$execute = $prepare -> execute(array($_POST['id']));
	if ($execute)
	{
		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
		if ($data['patent_author_id'] != $_SESSION['user_id'])
		{
            $response = array('status_response'  => 'error');
            echo json_encode($response);
		}
        else
        {
            unlink("upload/".$data['patent_src']);
            $sql = "delete from patent where patent_id = ?";
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
?>
