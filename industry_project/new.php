<?php
    session_start();
    require("../base.php");
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) )
    {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location:index' ) );
    }
    else
    {
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
            $title = $_POST["title"];
            $type = $_POST["type"];
        	$role = $_POST["role"];
            $source = $_POST["source"];
            $duration_from = $_POST["from"];
            $duration_to = $_POST["to"];
        	$amount = $_POST["amount"];
            $action = "";
            $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //Disable Prepared Statements, in case of SQL Injection.
            $sql = "insert into industry_project (ip_user_id, ip_title, ip_role, ip_fundsource, ip_duration_from, ip_duration_to, ip_amount, ip_type, action) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $prepare = $dbh -> prepare($sql);
            $execute = $prepare -> execute(array($_SESSION['user_id'], $title, $role, $source, $duration_from, $duration_to, $amount, $type, $action));
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
    $dbh = null;
?>
