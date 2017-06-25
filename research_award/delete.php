<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
    }
    session_start();
    header('Content-type: application/json');
    require("../base.php");
    $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
	  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	  $sql = "select research_award_author_id from research_award where research_award_id = ?";
	  $prepare = $dbh -> prepare($sql); // Statement is Statement.
	  $execute = $prepare -> execute(array($_POST['id']));
  	if ($execute)
  	{
  		$data = $prepare -> fetch(PDO::FETCH_ASSOC);
  		if ($data['research_award_author_id'] != $_SESSION['user_id'])
  		{
              header('HTTP/1.1 500 You are not allowed to delete it');
              header('Content-Type: application/json; charset=UTF-8');
              die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
  		}
  	}

    // unlink("upload/".$data['patent_src']);
    $sql = "delete from research_award where research_award_id = ?";
    $prepare = $dbh -> prepare($sql);
    $execute = $prepare -> execute(array($_POST['id']));
    $dbh = null;
?>
