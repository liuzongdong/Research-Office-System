<?php
    error_reporting(0);
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
            $old_password = $_POST["password"];
            $new_password = $_POST["new_password"];
            $password_confirm = $_POST["confirm_password"];
            if ($new_password != $password_confirm)
            {
                $response = array('status_response'  => 'unmatch');
                echo json_encode($response);
            }
            else
            {
                $password = password_hash($password_confirm, PASSWORD_DEFAULT);
                $dbh = new PDO($dbinfo,$dbusername,$dbpassword);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "select password from user where user_id = ?";
                $prepare = $dbh -> prepare($sql);
                $execute = $prepare -> execute(array($_SESSION["user_id"]));
                if ($execute)
                {
                    $row = $prepare -> fetch();
                    if (password_verify($old_password, $row['password']))
                    {
                        $sql = "update user set password = ? where user_id = ?";
                        $prepare = $dbh -> prepare($sql);
                        $execute = $prepare -> execute(array($password, $_SESSION["user_id"]));
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
                    else
                    {
                        $response = array('status_response'  => 'error');
                        echo json_encode($response);
                    }
                }
            }
        }
    }

?>
